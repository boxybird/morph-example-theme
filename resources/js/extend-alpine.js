document.addEventListener('alpine:init', () => {
  Alpine.magic('listen', () => (listener, callback) => {
    // Listen for fetch requests
    const fetch = window.fetch

    window.fetch = function () {
      const url = arguments[0]

      return fetch.apply(this, arguments).then((response) => {
        url.includes(listener) ? callback() : null

        return response
      })
    }

    // Listen for XHR requests
    const send = XMLHttpRequest.prototype.send

    XMLHttpRequest.prototype.send = function () {
      this.addEventListener('load', function () {
        this.responseURL.includes(listener) ? callback() : null
      })

      return send.apply(this, arguments)
    }
  })

  Alpine.magic('observe', () => (target, callback) => {
    const els = document.querySelectorAll(target)

    if (!els.length) return

    const observer = new MutationObserver((mutations) => {
      mutations.forEach((mutation) => {
        callback(mutation)
      })
    })

    els.forEach((el) => {
      observer.observe(el, {
        childList: true,
        attributes: true,
        subtree: true,
        characterData: true,
      })
    })
  })
})
