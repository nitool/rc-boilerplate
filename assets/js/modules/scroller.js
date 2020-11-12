module.exports = (element, pharmacyConfig) => {
    console.debug('Applying Rich Content scroller onto ' + element + ' a[data-target]');
    var scrollers = document.querySelectorAll(element + ' a[data-target]');
    for (var index in scrollers) {
        if (!scrollers.hasOwnProperty(index)) {
            continue;
        }

        var scroller = scrollers[index];
        scroller.addEventListener('click', function (event) {
            event.preventDefault();
            var target = event.target;
            var section = document.querySelector(target.getAttribute('data-target'));
            var offsetY = section.getBoundingClientRect().y;
            if (typeof pharmacyConfig !== 'undefined'
                && typeof pharmacyConfig.SCROLL_OFFSET !== 'undefined' 
                && !isNaN(pharmacyConfig.SCROLL_OFFSET)
            ) {
                offsetY -= pharmacyConfig.SCROLL_OFFSET;
            }

            window.scrollTo({
              top: offsetY,
              left: section.getBoundingClientRect().x,
              behavior: 'smooth'
            });
        });
    }
};
