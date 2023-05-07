import axios from "axios";
import Routing from '../../../../js/components/Routing';

const ApiService = {
  getUserInfos(steamId) {
    let url = Routing.generate('user_load', { steamId: steamId })

    return axios.get(url)
  },

  getPlayerGames(steamId, filters) {
    let url = Routing.generate('player_games', { steamId: steamId })

    return axios.post(url, filters)
  },

  getGamesInfos(appsIds, gamesIds) {
    let url = Routing.generate('games_infos')

    return axios.post(url, { appsIds: appsIds, gamesIds: gamesIds })
  }
}

export default ApiService;
