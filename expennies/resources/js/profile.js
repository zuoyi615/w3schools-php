import { post } from './ajax'

window.addEventListener('DOMContentLoaded', function () {
  const saveProfileBtn = document.querySelector('.save-profile')
  const updatePasswordBtn = document.querySelector('.update-password')
  
  saveProfileBtn.onclick = async function (event) {
    event.preventDefault()
    
    const form = this.closest('form')
    const formData = new FormData(form)
    const data = Object.fromEntries(formData.entries())
    
    try {
      saveProfileBtn.classList.add('disabled')
      const res = await post('/profile', data, form)
      if (!res.ok) {
        return
      }
      location.reload()
    } catch (e) {
      saveProfileBtn.classList.remove('disabled')
    }
  }
  
  updatePasswordBtn.onclick = async function () {
    const form = document.getElementById('passwordForm')
    const formData = new FormData(form)
    const data = Object.fromEntries(formData.entries())
    
    try {
      updatePasswordBtn.classList.add('disabled')
      const res = await post('/profile/update-password', data, form)
      if (!res.ok) {
        return
      }
      alert('Password has been updated.')
    } finally {
      updatePasswordBtn.classList.remove('disabled')
    }
  }
})
