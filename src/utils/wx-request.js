const host = 'http://localhost/ci/index.php/'

function request (url, method, data, header = {}) {
  wx.showLoading({
    title: 'loading' // 数据请求前loading
  })
  return new Promise((resolve, reject) => {
    wx.request({
      url: host + url, // 仅为示例，并非真实的接口地址
      method: method,
      data: data,
      header: {
        'content-type': 'application/x-www-form-urlencoded'
      },
      success: function (res) {
        wx.hideLoading()
        if (Number(res.statusCode) === 438) {
          console.log(res.data['message'])
          wx.showToast({ title: res.data['message'], icon: 'none' })
        } else if (Number(res.statusCode) !== 200) {
          wx.showToast({ title: '通讯错误，稍后再试', icon: 'none' })
        } else {
          resolve(res.data)
        }
      },
      fail: function (res) {
        wx.hideLoading()
        // reject(false)
      },
      complete: function () {
        wx.hideLoading()
      }
    })
  })
}

function get (obj) {
  return request(obj.url, 'GET', obj.data)
}

function post (obj) {
  return request(obj.url, 'POST', obj.data)
}

export default {
  request,
  get,
  post,
  host
}
