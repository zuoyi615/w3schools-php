import { Modal } from 'bootstrap'
import { get, post, del } from './ajax'

window.addEventListener('DOMContentLoaded', function () {
    const editCategoryModal = new Modal(document.getElementById('editCategoryModal'))

    document.querySelectorAll('.edit-category-btn').forEach(button => {
        button.onclick = async function (event) {
            const id = event.currentTarget.getAttribute('data-id')
            const res = await get(`/categories/${id}`)
            const data = await res.json()
            openEditCategoryModal(editCategoryModal, data)
        }
    })

    document.querySelector('.save-category-btn').onclick = async function (event) {
        const id = event.currentTarget.getAttribute('data-id')
        const name = editCategoryModal._element.querySelector('input[name="name"]').value
        const res = await post(`/categories/${id}`, { name }, editCategoryModal._element)
        if (res.ok) {
            editCategoryModal.hide();
        }
    }

    document.querySelectorAll('.delete-category-btn').forEach(button => {
        button.onclick = async function (event) {
            const id = event.currentTarget.getAttribute('data-id')
            console.log(id)
            if (confirm('Are you sure you want to delete this category')) {
                await del(`/categories/${id}`)
            }
        }
    })
})

function openEditCategoryModal (modal, { id, name }) {
    const nameInput = modal._element.querySelector('input[name="name"]')
    nameInput.value = name

    modal._element.querySelector('.save-category-btn').setAttribute('data-id', id)
    modal.show()
}
