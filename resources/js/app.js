import { createApp, h } from 'vue'
import { Head, Link, createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import AuthLayout from './Layouts/AuthLayout.vue';
import GuestLayout from './Layouts/GuestLayout.vue';

const appName = import.meta.env.VITE_APP_NAME || 'My App';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,

    resolve: async name => {
        const page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob("./Pages/**/*.vue"));

        if (page.default.layout === undefined) {
            page.default.layout = name.startsWith('Guest/') ? GuestLayout : AuthLayout;
        }

        return page;
    },

    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .component('Link', Link)
            .component('Head', Head)
            .mount(el)
    },

    progress: {
        delay: 250,
        color: 'red',
        includeCSS: true,
        showSpinner: true,
    },
})