import { Modal } from 'bootstrap'
import { del, get, post } from './ajax'
import DataTables from 'datatables.net'

function init () {
    const categoryModal = new Modal(document.getElementById('categoryModal'))
    const form = categoryModal._element.querySelector('#form')

    form.onsubmit = async function (event) {
        event.preventDefault();

        const { id, name } = getFormData(form)
        if (id) await edit(id, name)
        else await create(name)
    }

    const tableEl = document.querySelector('#categoriesTable')
    const table = new DataTables(tableEl, {
        serverSide: true,
        ajax: '/categories/load',
        orderMulti: false,
        columns: [
            { data: 'name' },
            { data: 'createdAt' },
            { data: 'updatedAt' },
            {
                sortable: false,
                data: row => `
                    <div class="d-flex flex-">
                        <button type="submit" class="btn btn-outline-primary delete-category-btn" data-id="${row.id}">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                        <button class="ms-2 btn btn-outline-primary edit-category-btn" data-id="${row.id}">
                            <i class="bi bi-pencil-fill"></i>
                        </button>
                    </div>
                `
            }
        ]
    })

    tableEl.onclick = async function (event) {
        const editBtn = event.target.closest('.edit-category-btn')
        const deleteBtn = event.target.closest('.delete-category-btn')

        if (editBtn) {
            const id = editBtn.getAttribute('data-id')
            const res = await get(`/categories/${id}`)
            const data = await res.json()

            setFormData(form, data)
            categoryModal.show()
        }

        if (deleteBtn) {
            const id = deleteBtn.getAttribute('data-id')
            if (confirm('Are you sure you want to delete this category')) {
                await del(`/categories/${id}`)
                table.draw()
            }
        }
    }

    document.querySelector('#createCategoryBtn').onclick = async function () {
        form.reset()
        categoryModal.show()
    }

    function refresh (res) {
        if (!res.ok) return
        table.draw()
        categoryModal.hide()
    }

    async function edit (id, name) {
        const res = await post(`/categories/${id}`, { name }, categoryModal._element)
        refresh(res)
    }

    async function create (name) {
        const res = await post(`/categories`, { name }, categoryModal._element)
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
    const { id, name } = form.elements
    return {
        id: id.value,
        name: name.value
    }
}
