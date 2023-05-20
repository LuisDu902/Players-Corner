function encodeForAjax(data) {
  return Object.keys(data).map(function (k) {
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}

const typed = new Typed('.auto-type', {
  strings: ["Player's Corner", "Adventure", "Experience", "Comfort"],
  typeSpeed: 100,
  backSpeed: 100,
  loop: true
})
