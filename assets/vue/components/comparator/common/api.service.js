import axios from "axios";
import Routing from '../../../../js/components/Routing';

const ApiService = {
  getUserInfos(steamId, filters) {
    let url = Routing.generate('user_load', { steamId: steamId })

    return axios.post(url, filters)
  },
}

export default ApiService;
