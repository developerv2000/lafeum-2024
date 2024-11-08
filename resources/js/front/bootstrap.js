import axios from 'axios';
import '../../custom-components/script';
import '../../../public/plugins/yandex-share'

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
