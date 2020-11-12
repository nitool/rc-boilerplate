const path = require('path');
const fs = require('fs');

module.exports = function loader(source) {
    const resource = this._module.resource;
    const pharmacyMatches = resource.match(/[?](\w+)?$/);
    if (pharmacyMatches === null || typeof pharmacyMatches[1] === 'undefined') {
        return source;
    }

    const pharmacy = pharmacyMatches[1];
    const config = path.resolve(__dirname, '..', 'pharmacies', pharmacy + '.js');
    if (null === config || !fs.existsSync(config)) {
        console.warn(`Couldn\'t find ${pharmacy} config file at ${config}. Using null.js config instead.`);

        return source.replace('PHARMACY_CONFIG', './pharmacies/null.js');
    }
    
    return source.replace('PHARMACY_CONFIG', `./pharmacies/${pharmacy}.js`);
}
