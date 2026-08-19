(function () {
  var KEY = 'tema';
  try { var t = localStorage.getItem(KEY); if (t) document.documentElement.setAttribute('data-theme', t); } catch (e) {}

  function pintarIcone() {
    var el = document.querySelector('.theme-icon');
    if (el) el.textContent = document.documentElement.getAttribute('data-theme') === 'dark' ? '☀️' : '🌙';
  }

  window.alternarTema = function () {
    var atual = document.documentElement.getAttribute('data-theme') === 'dark' ? 'dark' : 'light';
    var proximo = atual === 'dark' ? 'light' : 'dark';
    document.documentElement.setAttribute('data-theme', proximo);
    try { localStorage.setItem(KEY, proximo); } catch (e) {}
    pintarIcone();
  };

  document.addEventListener('DOMContentLoaded', pintarIcone);
})();

/* mascaras simples de input (substitui jquery.mask, sem CDN) */
(function () {
  function mascara(el, pat) {
    el.addEventListener('input', function () {
      var v = el.value.replace(/\D/g, ''), out = '', i = 0;
      for (var j = 0; j < pat.length && i < v.length; j++) {
        out += (pat[j] === '0') ? v[i++] : pat[j];
      }
      el.value = out;
    });
  }
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-mask]').forEach(function (el) {
      mascara(el, el.getAttribute('data-mask'));
    });
  });
})();

