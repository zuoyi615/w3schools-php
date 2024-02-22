import { Modal } from 'bootstrap'

window.addEventListener('DOMContentLoaded', function () {
    const editCategoryModal = new Modal(document.getElementById('editCategoryModal'))

    document.querySelectorAll('.edit-category-btn').forEach(button => {
        button.addEventListener('click', async function (event) {
            const id = event.currentTarget.getAttribute('data-id')

            const res = await fetch(`/categories/${id}`)
            const data = await res.json()

            openEditCategoryModal(editCategoryModal, data)
        })
    })

    document.querySelector('.save-category-btn').addEventListener('click', async function (event) {
        const id = event.currentTarget.getAttribute('data-id')
        const name = editCategoryModal._element.querySelector('input[name="name"]').value

        const res = await fetch(`/categories/${id}`, {
            method: 'POST',
            body: JSON.stringify({
                name,
                ...getCsrfFields()
            }),
            headers: {
                'Content-Type': 'application/json',
            },
        })
        console.log(await res.json())
    })
})

function openEditCategoryModal (modal, { id, name }) {
    const nameInput = modal._element.querySelector('input[name="name"]')
    nameInput.value = name

    modal._element.querySelector('.save-category-btn').setAttribute('data-id', id)
    modal.show()
}

function getCsrfFields () {
    const nameEl = document.querySelector('#csrfName')
    const csrfNameKey = nameEl.getAttribute('name')
    const csrfName = nameEl.content

    const valueEl = document.querySelector('#csrfValue')
    const csrfValueKey = valueEl.getAttribute('name')
    const csrfValue = valueEl.content

    return {
        [csrfNameKey]: csrfName,
        [csrfValueKey]: csrfValue
    }
}
