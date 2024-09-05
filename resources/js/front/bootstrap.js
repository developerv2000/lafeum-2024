import axios from 'axios';
import '../global/components'
import '../../../public/plugins/yandex-share'

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
