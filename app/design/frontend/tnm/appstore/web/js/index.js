const accordionItems = document.querySelectorAll(".accordion-item-header");

accordionItems.forEach(accordionItem => {
  accordionItem.addEventListener("click", event => {

    accordionItem.classList.toggle("active");
    const accordionItemBody = accordionItem.nextElementSibling;
    if(accordionItem.classList.contains("active")) {
      accordionItemBody.style.maxHeight = accordionItemBody.scrollHeight + "px";
    }
    else {
      accordionItemBody.style.maxHeight = 0;
    }
  });
});


require(['jquery','select2'], (function($) {
    var brandSelector, modelSelector, variantSelector;
    var currentToggleState, _selected, _id, _globalResponse;

    function log(...args) {
        console.log(...args);
    }

    function __find(id) {
        return function(o) {
            return o.entity_id == id;
        }
    }

    function __ddmap(o) {
        return {
            id: o.entity_id,
            text: o.name
        };
    }

    function initSelect(el, placeholder) {
        return function(_e) {
            var entry = _e.childes.map(__ddmap);
            entry.unshift({
                id: '',
                text: ''
            });
            el.html('').select2({
                data: entry,
                placeholder: placeholder
            });
        }
    }

    function toggleState(e) {
        try {
            e.preventDefault();
            e.stopPropagation();
        } catch {}
        currentToggleState = $(this).data('state');
        refresh();
    }

    function updateSelector(selector, placeholder) {
        return function(e) {
            try {
                e.preventDefault();
                e.stopPropagation();
            } catch {}
            var id = $(this).val();
            var next = _selected.childes.find(__find(id));

            if (next !== undefined) {
                _id = next.childes.length > 0 ? id : null;
                _selected = next;
                if (selector !== null) {
                    initSelect(selector, placeholder)(next);
                }
            }
        }
    }

    function updateFinal(e) {
        try {
            e.preventDefault();
            e.stopPropagation();
        } catch {}
        var id = $(this).val();
        _id = id;
    }

    function submitSearch(e) {
        try {
            e.preventDefault();
            e.stopPropagation();
        } catch {}

        var next = undefined;

        if (_id !== null) {
            next = _selected.childes.find(__find(_id));
        } else {
            next = _selected;
        }
        if (next) {
            window.location.href = next.request_path;
        }
    }

    function refresh() {
        _selected = _globalResponse.find(__find(currentToggleState));
        if (_selected !== undefined) {
            initSelect(brandSelector, 'Select Brand')(_selected);
            modelSelector.html('').select2();
            variantSelector.html('').select2();
        }
    }

    function _init(response) {
        if (typeof response === 'string') {
            response = JSON.parse(response);
        }
        _globalResponse = response;
        refresh();
    }

    // Script Entry Point
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdowns with Select2
        $('[data-selector]').select2();
        brandSelector = $('[data-selector="brand"]').first();
        modelSelector = $('[data-selector="model"]').first();
        variantSelector = $('[data-selector="variant"]').first();
        brandSelector.on('change', updateSelector(modelSelector, 'Select Model'));
        modelSelector.on('change', updateSelector(variantSelector, 'Select Variant'));
        variantSelector.on('change', updateFinal);
        // Toggle Event Listeners
        $('[data-search-toggle]').on('click', toggleState);

        // Configure Search Button
        $('[data-search-init]').on('click', submitSearch);

        // Set current State
        currentToggleState = $('[data-search-toggle].active').first().data('state');
        $.get('https://tyres.clarksfield.com/tyreadvanceserch/index/parentcetegory').then(_init);
    });
}));

