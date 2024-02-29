import { Modal } from 'bootstrap'
import { del, get, post } from './ajax'
import DataTables from 'datatables.net'

function currency (amount) {
    return Intl
        .NumberFormat(
            'en-US',
            {
                style: 'currency',
                currency: 'USD',
                currencySign: 'accounting'
            }
        )
        .format(amount)
}

function init () {
    const modal = new Modal(document.querySelector('#transactionModal'))
    const form = modal._element.querySelector('#form')

    const uploadModal = new Modal(document.querySelector('#uploadReceiptModal'))
    const uploadForm = uploadModal._element.querySelector('#uploadForm')

    form.onsubmit = async function (event) {
        event.preventDefault();

        const data = getFormData(form)

        if (data.id) await edit(data)
        else await create(data)
    }

    uploadForm.onsubmit = async function (event) {
        event.preventDefault()
        const data = getUploadFormData(uploadForm)
        await upload(data)
    }

    const tableEl = document.querySelector('#transactionsTable')
    const table = new DataTables(tableEl, {
        serverSide: true,
        ajax: '/transactions/load',
        orderMulti: false,
        columns: [
            { data: 'description' },
            { data: ({ amount }) => currency(amount) },
            { data: 'categoryName' },
            {
                data: row => {
                    const icons = []

                    row.receipts?.forEach(receipt => {
                        const span = document.createElement('span')
                        const anchor = document.createElement('a')
                        const icon = document.createElement('i')
                        const deleteIcon = document.createElement('i')

                        deleteIcon.role = 'button'

                        span.classList.add('position-relative')
                        icon.classList.add('bi', 'bi-file-earmark-text', 'download-receipt', 'text-primary', 'fs-4')
                        deleteIcon.classList.add('bi', 'bi-x-circle-fill', 'delete-receipt', 'text-danger', 'position-absolute')

                        anchor.href = `/transactions/${row.id}/receipts/${receipt.id}`
                        anchor.target = 'blank'
                        anchor.title = receipt.name

                        deleteIcon.setAttribute('data-id', receipt.id)
                        deleteIcon.setAttribute('data-transactionId', row.id)

                        anchor.append(icon)
                        span.append(anchor)
                        span.append(deleteIcon)

                        icons.push(span.outerHTML)
                    })

                    return icons.join('')
                }
            },
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
                        <button class="ms-2 btn btn-outline-primary upload-btn" data-id="${row.id}">
                            <i class="bi bi-upload"></i>
                        </button>
                    </div>
                `
            }
        ]
    })

    tableEl.onclick = async function (event) {
        const editBtn = event.target.closest('.edit-btn')
        const deleteBtn = event.target.closest('.delete-btn')
        const uploadBtn = event.target.closest('.upload-btn')
        const deleteReceiptBtn = event.target.closest('.delete-receipt')

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

        if (uploadBtn) {
            const id = uploadBtn.getAttribute('data-id')
            resetForm(uploadForm)
            setFormData(uploadForm, { id })
            uploadModal.show()
        }

        if (deleteReceiptBtn) {
            const receiptId = deleteReceiptBtn.getAttribute('data-id')
            const transactionId = deleteReceiptBtn.getAttribute('data-transactionid')
            if (confirm('Are you sure you want to delete this receipt?')) {
                const res = await del(`/transactions/${transactionId}/receipts/${receiptId}`);
                refresh(res)
            }
        }
    }

    document.querySelector('#createBtn').onclick = async function () {
        resetForm(form)
        modal.show()
    }

    function refresh (res, modal) {
        if (!res.ok) return
        table.draw()
        modal?.hide()
    }

    async function edit (data) {
        const res = await post(`/transactions/${data.id}`, data, modal._element)
        refresh(res, modal)
    }

    async function create (data) {
        const res = await post(`/transactions`, data, modal._element)
        refresh(res, modal)
    }

    async function upload ({ id, receipt }) {
        const res = await post(`/transactions/${id}/receipts`, receipt, uploadModal._element)
        refresh(res, uploadModal)
    }
}

window.addEventListener('DOMContentLoaded', init, { once: true })

function setFormData (form, data) {
    for (const [field, value] of Object.entries(data)) {
        form.elements[field].value = value
    }
}

function resetForm (form) {
    form.reset()
    const hiddenFields = form.querySelectorAll('input[type=hidden]')
    hiddenFields.forEach(input => input.value = '')
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

function getUploadFormData (form) {
    const { id, receipt } = form.elements

    const formData = new FormData()
    Array.from(receipt.files).forEach(file => formData.append('receipt', file))

    return {
        id: id.value,
        receipt: formData
    }
}
