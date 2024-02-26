import { Modal } from 'bootstrap'
import { del, get, post } from './ajax'
import DataTables from 'datatables.net'

function init () {
    const editCategoryModal = new Modal(document.getElementById('editCategoryModal'))
    const newCategoryModal = new Modal(document.getElementById('newCategoryModal'))
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
            openEditCategoryModal(editCategoryModal, data)
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
        newCategoryModal.show()
    }

    document.querySelector('.save-category-btn').onclick = async function (event) {
        const id = event.currentTarget.getAttribute('data-id')
        const name = editCategoryModal._element.querySelector('input[name="name"]').value
        const res = await post(`/categories/${id}`, { name }, editCategoryModal._element)
        if (!res.ok) return
        table.draw()
        editCategoryModal.hide()
    }

    document.querySelector('.create-category-btn').onclick = async function () {
        const name = newCategoryModal._element.querySelector('input[name="name"]').value
        const res = await post(`/categories`, { name }, newCategoryModal._element)
        if (!res.ok) return
        table.draw()
        newCategoryModal.hide()
    }
}

window.addEventListener('DOMContentLoaded', init, { once: true })

function openEditCategoryModal (modal, { id, name }) {
    const nameInput = modal._element.querySelector('input[name="name"]')
    nameInput.value = name

    modal._element.querySelector('.save-category-btn').setAttribute('data-id', id)
    modal.show()
}
