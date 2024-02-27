const ajax = async (url, method = 'get', data = {}, domElement = null) => {
    method = method.toLowerCase()

    const options = {
        method,
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    }

    const csrfMethods = new Set(['post', 'put', 'delete', 'patch'])

    if (csrfMethods.has(method)) {
        if (method !== 'post') {
            options.method = 'post'
            data = { ...data, _METHOD: method.toUpperCase() }
        }

        options.body = JSON.stringify({ ...data, ...getCsrfFields() })
    } else if (method === 'get') {
        url += '?' + (new URLSearchParams(data)).toString();
    }

    const res = await fetch(url, options)
    if (domElement != null) clearValidationErrors(domElement)

    const { ok, status } = res

    if (!ok) {
        if (status === 422) {
            handleValidationErrors(await res.json(), domElement)
        }
    }

    return res
}

const get = (url, data) => ajax(url, 'get', data)
const post = (url, data, domElement) => ajax(url, 'post', data, domElement)
const del = (url, data) => ajax(url, 'delete', data)


function handleValidationErrors (errors, domElement) {
    if (!domElement) {
        return
    }

    for (const name in errors) {
        const el = domElement.querySelector(`[name="${name}"]`)
        el.classList.add('is-invalid')

        for (const error of errors[name]) {
            const fragment = document.createDocumentFragment()
            const errorDiv = document.createElement('div')
            errorDiv.classList.add('invalid-feedback')
            errorDiv.textContent = error
            fragment.append(errorDiv)
            el.parentNode.append(fragment)
        }
    }
}

function clearValidationErrors (domElement) {
    domElement.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid')
        el.querySelectorAll('.invalid-feedback').forEach(item => item.remove())
    });
}

function getCsrfFields () {
    const csrfNameField = document.querySelector('#csrfName')
    const csrfValueField = document.querySelector('#csrfValue')
    const csrfNameKey = csrfNameField.getAttribute('name')
    const csrfName = csrfNameField.content
    const csrfValueKey = csrfValueField.getAttribute('name')
    const csrfValue = csrfValueField.content

    return {
        [csrfNameKey]: csrfName,
        [csrfValueKey]: csrfValue
    }
}

export {
    ajax,
    get,
    post,
    del
}
