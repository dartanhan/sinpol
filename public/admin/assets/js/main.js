/**
* Template Name: NiceAdmin
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Updated: Apr 20 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

(function () {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
   * Easy on scroll event listener
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Sidebar toggle
   */
  if (select('.toggle-sidebar-btn')) {
    on('click', '.toggle-sidebar-btn', function (e) {
      select('body').classList.toggle('toggle-sidebar')
    })
  }

  /**
   * Search bar toggle
   */
  if (select('.search-bar-toggle')) {
    on('click', '.search-bar-toggle', function (e) {
      select('.search-bar').classList.toggle('search-bar-show')
    })
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Initiate tooltips
   */
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  /**
   * Initiate quill editors
   */
  if (select('.quill-editor-default')) {
    new Quill('.quill-editor-default', {
      theme: 'snow'
    });
  }

  if (select('.quill-editor-bubble')) {
    new Quill('.quill-editor-bubble', {
      theme: 'bubble'
    });
  }

  if (select('.quill-editor-full')) {
    new Quill(".quill-editor-full", {
      modules: {
        toolbar: [
          [{
            font: []
          }, {
            size: []
          }],
          ["bold", "italic", "underline", "strike"],
          [{
            color: []
          },
          {
            background: []
          }
          ],
          [{
            script: "super"
          },
          {
            script: "sub"
          }
          ],
          [{
            list: "ordered"
          },
          {
            list: "bullet"
          },
          {
            indent: "-1"
          },
          {
            indent: "+1"
          }
          ],
          ["direction", {
            align: []
          }],
          ["link", "image", "video"],
          ["clean"]
        ]
      },
      theme: "snow"
    });
  }

  /**
   * Initiate TinyMCE Editor
   */

  const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

  tinymce.init({
    selector: 'textarea.tinymce_editor',
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
    editimage_cors_hosts: ['picsum.photos'],
    images_upload_handler: (blobInfo, progress) => new Promise((resolve, reject) => {
      const xhr = new XMLHttpRequest();
      xhr.withCredentials = false;
      xhr.open('POST', '/admin/upload/tinymce');
      const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
      xhr.setRequestHeader("X-CSRF-Token", token);

      xhr.upload.onprogress = (e) => {
        progress(e.loaded / e.total * 100);
      };

      xhr.onload = () => {
        if (xhr.status === 403) {
          reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
          return;
        }
        if (xhr.status < 200 || xhr.status >= 300) {
          reject('HTTP Error: ' + xhr.status);
          return;
        }

        const json = JSON.parse(xhr.responseText);

        if (!json || typeof json.location != 'string') {
          reject('Invalid JSON: ' + xhr.responseText);
          return;
        }

        resolve(json.location);
      };

      xhr.onerror = () => {
        reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
      };

      const formData = new FormData();
      formData.append('file', blobInfo.blob(), blobInfo.filename());

      xhr.send(formData);
    }),
    menubar: 'file edit view insert format tools table help',
    toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
    relative_urls: false,
    remove_script_host: false,
    convert_urls: false,
    extended_valid_elements: 'iframe[src|frameborder|style|scrolling|key|width|height|allowfullscreen|allow],video[src|poster|width|height|controls|preload|autoplay|loop|muted],source[src|type]',
    media_live_embeds: true,
    autosave_ask_before_unload: true,
    toolbar_sticky_offset: isSmallScreen ? 102 : 108,
    autosave_interval: '30s',
    autosave_prefix: '{path}{query}-{id}-',
    autosave_restore_when_empty: false,
    autosave_retention: '2m',
    image_advtab: true,
    language: 'pt_BR',
    link_list: [
      { title: 'Home', value: '/' },
      { title: 'Benefícios', value: '/home/beneficio' },
      { title: 'Notícias', value: '/home/outrasnoticias' },
      { title: 'Galeria de Imagens', value: '/home/socialmedia' },
      { title: 'Convênios', value: '/home/convenio' },
      { title: 'Diretoria', value: '/home/diretoria' },
      { title: 'História', value: '/home/historia' },
      { title: 'Fale Conosco', value: '/home/fale-conosco' },
      { title: 'Como Chegar', value: '/home/como-chegar' },
      { title: 'Principais Links', value: '/home/principais-links' },
      { title: 'Sinpol Animal', value: '/home/sinpol-animal' },
      { title: 'Sinpol Mulher', value: '/home/sinpol-mulher' },
      { title: 'Sinpol Permutas', value: '/home/sinpol-permutas' },
      { title: 'Classificados', value: '/home/classificados-sinpol' },
      { title: 'Sinpol Fiscaliza', value: '/home/sinpol-fiscaliza' },
      { title: 'Sinpol Na Rua', value: '/home/sinpol-na-rua' },
      { title: 'Sinpol Denúncias', value: '/home/sinpol-denuncias' },
      { title: 'Sinpol Idoso', value: '/home/sinpol-idoso' },
      { title: 'Sinpol Esportes', value: '/home/sinpol-esportes' },
      { title: 'Sinpol Peritos', value: '/home/sinpol-peritos' }
    ],
    image_list: [{
      title: 'My page 1',
      value: 'https://www.tiny.cloud'
    },
    {
      title: 'My page 2',
      value: 'http://www.moxiecode.com'
    }
    ],
    image_class_list: [{
      title: 'None',
      value: ''
    },
    {
      title: 'Some class',
      value: 'class-name'
    }
    ],
    importcss_append: true,
    file_picker_callback: (callback, value, meta) => {
      const input = document.createElement('input');
      input.setAttribute('type', 'file');

      if (meta.filetype === 'image') {
        input.setAttribute('accept', 'image/*');
      } else if (meta.filetype === 'media') {
        input.setAttribute('accept', 'video/*,audio/*');
      }

      input.onchange = function () {
        const file = this.files[0];
        
        // 30MB limit check
        const maxBytes = 30 * 1024 * 1024;
        if (file.size > maxBytes) {
            const limitMsg = 'O arquivo selecionado é muito grande (excede o limite de tamanho permitido de 30MB).';
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de Tamanho',
                    text: limitMsg,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Entendido'
                });
            } else {
                alert(limitMsg);
            }
            return;
        }

        const formData = new FormData();
        formData.append('file', file, file.name);

        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/admin/upload/tinymce');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        if (token) {
            xhr.setRequestHeader("X-CSRF-Token", token);
        }

        xhr.onload = function () {
          if (xhr.status < 200 || xhr.status >= 300) {
            let errorMsg = 'Ocorreu um erro ao enviar o arquivo.';
            if (xhr.status === 413 || xhr.statusText === 'Request Entity Too Large') {
              errorMsg = 'O arquivo selecionado é muito grande (excede o limite de tamanho permitido no servidor: máximo de 30MB).';
            } else if (xhr.status === 403 || xhr.status === 401) {
              errorMsg = 'Você não tem permissão para realizar este envio. Sua sessão pode ter expirado.';
            } else if (xhr.statusText) {
              errorMsg = 'Erro: ' + xhr.statusText;
            }

            if (typeof Swal !== 'undefined') {
              Swal.fire({
                icon: 'error',
                title: 'Erro de Envio',
                text: errorMsg,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Entendido'
              });
            } else {
              alert('Erro ao enviar arquivo: ' + errorMsg);
            }
            return;
          }

          const json = JSON.parse(xhr.responseText);
          if (json && typeof json.location === 'string') {
            callback(json.location, { text: file.name, title: file.name, alt: file.name });
          }
        };

        xhr.onerror = function () {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              icon: 'error',
              title: 'Erro de Conexão',
              text: 'Não foi possível conectar ao servidor para enviar o arquivo. Verifique sua conexão com a internet.',
              confirmButtonColor: '#3085d6',
              confirmButtonText: 'Entendido'
            });
          } else {
            alert('Erro na conexão ao enviar o arquivo.');
          }
        };

        xhr.send(formData);
      };

      input.click();
    },
    height: 400,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_class: 'mceNonEditable',
    toolbar_mode: 'sliding',
    contextmenu: 'link image table',
    skin: useDarkMode ? 'oxide-dark' : 'oxide',
    content_css: useDarkMode ? 'dark' : 'default',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
  });

  /**
   * Initiate Bootstrap validation check
   */
  var needsValidation = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(needsValidation)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })

  /**
   * Initiate Datatables
   */
  const datatables = select('.datatable', true)
  datatables.forEach(datatable => {
    new simpleDatatables.DataTable(datatable, {
      perPageSelect: [5, 10, 15, ["Todas", -1]],
      labels: {
        placeholder: "Pesquisar...",
        perPage: "itens por página",
        noRows: "Nenhum registro encontrado",
        info: "Exibindo {start} a {end} de {rows} itens",
        noResults: "Nenhum resultado corresponde à sua pesquisa",
      },
      columns: [{
        select: 2,
        sortSequence: ["desc", "asc"]
      },
      {
        select: 3,
        sortSequence: ["desc"]
      },
      {
        select: 4,
        cellClass: "green",
        headerClass: "red"
      }
      ]
    });
  })

  const mainContainer = select('#main');
  if (mainContainer) {
    setTimeout(() => {
      new ResizeObserver(function () {
        select('.echart', true).forEach(getEchart => {
          echarts.getInstanceByDom(getEchart).resize();
        })
      }).observe(mainContainer);
    }, 200);
  }

  // Disable Bootstrap focus trapping globally to prevent it from blocking TinyMCE inputs
  if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
      if (bootstrap.Modal.Default) {
          bootstrap.Modal.Default.focus = false;
      }
  }

  document.addEventListener('focusin', function(e) {
      if (e.target && e.target.closest && e.target.closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root, .tox-dialog")) {
          const dialog = document.querySelector('.tox-dialog');
          if (dialog) {
              dialog.style.zIndex = '2003';
          }
          e.stopImmediatePropagation();
      }
  });

  // Global loading state on form submit buttons (Vanilla JS)
  document.addEventListener('submit', function(e) {
      const form = e.target;
      if (e.defaultPrevented) {
          return;
      }
      
      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
          // If the form has TinyMCE, make sure it has content and trigger save
          let hasEmptyTiny = false;
          form.querySelectorAll('textarea.tinymce_editor').forEach(function(textarea) {
              const editor = typeof tinymce !== 'undefined' ? tinymce.get(textarea.id) : null;
              if (editor) {
                  const content = editor.getContent().trim();
                  if (content === "") {
                      hasEmptyTiny = true;
                  } else {
                      editor.save();
                  }
              }
          });

          if (hasEmptyTiny) {
              return; // Let the custom validator handle it
          }

          // Disable and add loading spinner
          setTimeout(function() {
              submitBtn.disabled = true;
          }, 1);

          const originalText = submitBtn.textContent.trim();
          let loadingText = 'Aguarde...';
          
          if (originalText.toLowerCase().includes('salvar')) {
              loadingText = 'Salvando...';
          } else if (originalText.toLowerCase().includes('enviar')) {
              loadingText = 'Enviando...';
          } else if (originalText.toLowerCase().includes('entrar')) {
              loadingText = 'Entrando...';
          }

          submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText.toUpperCase()}`;
      }
  });

  // Override HTMLFormElement.prototype.submit to trigger loading state on programmatic submit
  const originalSubmit = HTMLFormElement.prototype.submit;
  HTMLFormElement.prototype.submit = function() {
      const submitBtn = this.querySelector('button[type="submit"]');
      if (submitBtn) {
          this.querySelectorAll('textarea.tinymce_editor').forEach(function(textarea) {
              const editor = typeof tinymce !== 'undefined' ? tinymce.get(textarea.id) : null;
              if (editor) {
                  editor.save();
              }
          });

          const originalText = submitBtn.textContent.trim();
          let loadingText = 'Aguarde...';
          
          if (originalText.toLowerCase().includes('salvar')) {
              loadingText = 'Salvando...';
          } else if (originalText.toLowerCase().includes('enviar')) {
              loadingText = 'Enviando...';
          } else if (originalText.toLowerCase().includes('entrar')) {
              loadingText = 'Entrando...';
          }

          submitBtn.disabled = true;
          submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText.toUpperCase()}`;
      }
      originalSubmit.apply(this);
  };

  // Global loading state on navigation/click buttons (Vanilla JS)
  document.addEventListener('click', function(e) {
      const btn = e.target.closest('.btn');
      if (!btn) {
          return;
      }

      // Skip submit buttons (handled by submit event), dropdown/modal toggles, delete buttons (handled by SweetAlert)
      if (btn.getAttribute('type') === 'submit' || 
          btn.classList.contains('dropdown-toggle') || 
          btn.classList.contains('btn-excluir-secao') || 
          btn.classList.contains('btn-excluir')) {
          return;
      }

      // Check if it's a Bootstrap modal trigger (like Galeria button)
      if (btn.getAttribute('data-toggle') === 'modal' || 
          btn.getAttribute('data-bs-toggle') === 'modal' || 
          btn.getAttribute('data-target') || 
          btn.getAttribute('data-bs-target') ||
          btn.hasAttribute('data-toggle') ||
          btn.hasAttribute('data-bs-toggle')) {
          
          if (btn.textContent.toLowerCase().includes('galeria')) {
              const originalHtml = btn.innerHTML;
              btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>GALERIA';
              setTimeout(function() {
                  btn.innerHTML = originalHtml;
              }, 800);
          }
          return;
      }

      // Check if it's a standard link/redirect
      const href = btn.getAttribute('href');
      if (href && href !== '#' && !href.startsWith('javascript:')) {
          const originalText = btn.textContent.trim();
          let loadingText = 'Aguarde...';
          
          if (originalText.toLowerCase().includes('voltar')) {
              loadingText = 'Voltando...';
          } else if (originalText.toLowerCase().includes('nova') || originalText.toLowerCase().includes('adicionar') || originalText.toLowerCase().includes('cadastrar')) {
               loadingText = 'Carregando...';
          } else if (originalText.toLowerCase().includes('editar')) {
              loadingText = 'Carregando...';
          } else if (originalText.toLowerCase().includes('cancelar')) {
              loadingText = 'Cancelando...';
          }

          btn.classList.add('disabled');
          btn.style.pointerEvents = 'none';
          btn.innerHTML = `<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>${loadingText.toUpperCase()}`;
      }
  });

})();
