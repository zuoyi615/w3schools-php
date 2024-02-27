import { Modal } from 'bootstrap'
import { del, get, post } from './ajax'
import DataTables from 'datatables.net'

function init () {
    const modal = new Modal(document.getElementById('transactionModal'))
    const form = modal._element.querySelector('#form')

    form.onsubmit = async function (event) {
        event.preventDefault();

        const data = getFormData(form)

        if (data.id) await edit(data)
        else await create(data)
    }

    const tableEl = document.querySelector('#transactionsTable')
    const table = new DataTables(tableEl, {
        serverSide: true,
        ajax: '/transactions/load',
        orderMulti: false,
        columns: [
            { data: 'description' },
            {
                data (row) {
                    return new Intl()
                        .NumberFormat(
                            'en-US',
                            {
                                style: 'currency',
                                currency: 'USD',
                                currencySign: 'accounting'
                            }
                        )
                        .format(row.amount)
                }
            },
            { data: 'category' },
            { data: 'date' },
            {
                sortable: false,
                data: row => `
                    <div class="d-flex flex-">
                        <button type="submit" class="btn btn-outline-primary delete-btn" data-id="${row.id}">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                        <button class="ms-2 btn btn-outline-primary edit-btn" data-id="${row.id}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    </div>
                `
            }
        ]
    })

    tableEl.onclick = async function (event) {
        const editBtn = event.target.closest('.edit-btn')
        const deleteBtn = event.target.closest('.delete-btn')

        if (editBtn) {
            const id = editBtn.getAttribute('data-id')
            const res = await get(`/transactions/${id}`)
            const data = await res.json()

            setFormData(form, data)
            modal.show()
        }

        if (deleteBtn) {
            const id = deleteBtn.getAttribute('data-id')
            if (confirm('Are you sure you want to delete this transaction')) {
                await del(`/transactions/${id}`)
                table.draw()
            }
        }
    }

    document.querySelector('#createBtn').onclick = async function () {
        form.reset()
        modal.show()
    }

    function refresh (res) {
        if (!res.ok) return
        // table.draw()
        // modal.hide()
    }

    async function edit (data) {
        const res = await post(`/transactions/${data.id}`, data, modal._element)
        refresh(res)
    }

    async function create (data) {
        const res = await post(`/transactions`, data, modal._element)
        refresh(res)
    }
}

window.addEventListener('DOMContentLoaded', init, { once: true })

function setFormData (form, data) {
    for (const [field, value] of Object.entries(data)) {
        form.elements[field].value = value
    }
}

function getFormData (form) {
    const { id, description, amount, date, category } = form.elements

    return {
        id: id.value,
        amount: amount.value,
        description: description.value,
        date: date.value,
        category: category.value
    }
}
