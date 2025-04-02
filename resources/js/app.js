import '../css/app.css';
import './bootstrap';
import { createApp } from 'vue';
import CsvUploader from './components/CsvUploader.vue';
import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp({});
app.component('example-component', ExampleComponent);
app.component('csv-uploader', CsvUploader);
app.mount('#app');