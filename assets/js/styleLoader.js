function getStyles(className, href) {
    var head = document.getElementsByTagName('head')[0];
    var link = document.createElement('link');
    link.id = className;
    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = href;
    link.media = 'all';
    head.appendChild(link);
}

function loadStyles() {
    for (var name in window.RC.stylesToLoad) {
        if (!window.RC.stylesToLoad.hasOwnProperty(name)) {
            continue;
        }

        var url = window.RC.stylesToLoad[name];
        delete window.RC.stylesToLoad[name];
        getStyles(name, url);
    }
}

function styleLoader() {
    window.RC = window.RC || {};
    window.RC.stylesToLoad = window.RC.stylesToLoad || {}

    document.onreadystatechange = function () {
        if (document.readyState === 'complete') {
            loadStyles();
        }
    }

    loadStyles();
}

styleLoader();
