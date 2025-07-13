(function(doc){
  var scriptElm = doc.scripts[doc.scripts.length - 1];
  var warn = ['[ionicons] Deprecated script detected. Consider removing: ' + scriptElm.outerHTML];

  warn.push('For better performance, load differential scripts in the head like this:');

  var parts = scriptElm.src.split('/');
  parts.pop();
  var baseUrl = parts.join('/') + '/ionicons';

  function addScript(src, type, nomodule) {
    if (!doc.querySelector('script[src="' + src + '"]')) {
      var script = doc.createElement('script');
      script.setAttribute('type', type);
      script.src = src;
      script.setAttribute('data-stencil-namespace', 'ionicons');
      if (nomodule) script.setAttribute('nomodule', '');
      doc.head.appendChild(script);
      warn.push(script.outerHTML);
    }
  }

  addScript(baseUrl + '.esm.js', 'module', false);
  addScript(baseUrl + '.js', 'text/javascript', true);

  console.warn(warn.join('\n'));

})(document);