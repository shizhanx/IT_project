import { get, post } from '../utils/request'

const API_URL = 'https://test.youbaobao.xyz:18081'
const APP_ID = 'wx5126ef9d22062d84'
const APP_SECRET = '4687dbf252d2182b56b4e4b05b7ad62d'

export function getHomeData(params) {
  return get(`${API_URL}/book/home/v2`, params)
}

export function recommend() {
  return get(`${API_URL}/book/home/recommend/v2`)
}

export function freeRead() {
  return get(`${API_URL}/book/home/freeRead/v2`)
}

export function hotBook() {
  return get(`${API_URL}/book/home/hotBook/v2`)
}

export function getOpenId(code) {
  return get(`${API_URL}/openId/get`, {
    appId: APP_ID,
    secret: APP_SECRET,
    code
  })
}

export function register(openId, userInfo) {
  return post(`${API_URL}/user/register`, {
    openId,
    platform: mpvuePlatform,
    ...userInfo
  })
}

export function bookDetail(params) {
  return get(`${API_URL}/book/detail`, params)
}

export function bookRankSave(params) {
  return get(`${API_URL}/book/rank/save`, params)
}

export function bookContents(params) {
  return get(`${API_URL}/book/contents`, params)
}

export function bookIsInShelf(params) {
  return get(`${API_URL}/book/shelf/get`, params)
}

export function bookShelfSave(params) {
  return get(`${API_URL}/book/shelf/save`, {
    shelf: JSON.stringify(params)
  })
}
