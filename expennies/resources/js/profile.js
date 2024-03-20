import { post } from './ajax'

window.addEventListener('DOMContentLoaded', function () {
  const saveProfileBtn = document.querySelector('.save-profile')
  
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
})
