import Vue from 'vue';
import VModal from 'vue-js-modal'
import Snotify, { SnotifyPosition } from 'vue-snotify';

// Register all the Vue components
const files = require.context('../../', true, /\.vue$/i);
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Start Turbolinks
require('turbolinks').start();

// Boot the Vue component
document.addEventListener('turbolinks:load', (event) => {
    const root = document.getElementById('app');

    if (window.vue) {
        window.vue.$destroy(true);
    }

    // Include SNotify for notifications
    const options = {
        toast: {
            position: SnotifyPosition.rightTop,
            timeout: 3000,
            showProgressBar: true,
            closeOnClick: false,
            pauseOnHover: true,
        }
    }
    Vue.use(Snotify, options);

    Vue.use(VModal, { componentName: "modal-component" });

    window.vue = new Vue({
        render: h => h(
            Vue.component(root.dataset.component), {
                props: JSON.parse(root.dataset.props)
            }
        )
    }).$mount(root);
})