import axios from "axios";
import Routing from '../../../../js/components/Routing';

const ApiService = {
  load() {
    let url = Routing.generate('calendar_index')

    return axios.get(url)
  },
}

export default ApiService;
