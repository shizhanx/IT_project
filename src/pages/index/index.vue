<template>
  <div>
    <div class="home" v-if="isAuth">
      <SearchBar
        :disabled="false"
        @onClick="onSearchBarClick"
        :hot-search='hotSearch'
      />
      <div class="personalInfo">
        <van-button round type="info" @click="toUserInfoClick">修改个人信息</van-button>
      </div>
      <HomeCard
        :data="homeCard"
        @onClick="onHomeBookClick"
      />
      <van-divider />
      <van-grid>
        <van-grid-item icon="notes-o" text="备忘录" @click="onMemoClick"/>
        <van-grid-item icon="https://www.easyicon.net/api/resizeApi.php?id=1221640&size=128" text="天气" @click="onWeatherClick"/>
        <van-grid-item icon="diamond-o" text="家族座右铭" url="https://www.baidu.com/"/>
        <van-grid-item icon="like-o" text="悄悄话" />
      </van-grid>
      <van-divider />
      <HomeBanner
        img="/static/images/1.png"
        title="lalala啦"
        subTitle="点击查看"
        @onClick="onBannerClick"
      />
      <div :style="{marginTop: '23px'}" v-if="false">
        <HomeBook
          title="咕噜咕噜"
          :row="1"
          :col="3"
          :data="recommend"
          mode="col"
          btn-text="换一批"
          @onMoreClick="recommendChange('recommend')"
          @onBookClick="onBookMoreClick"
        />
      </div>
    </div>
    <Auth v-if="!isAuth" @getUserInfo="init"/>
  </div>
</template>

<script>
  import SearchBar from '../../components/home/SearchBar'
  import HomeCard from '../../components/home/HomeCard'
  import HomeBanner from '../../components/home/HomeBanner'
  import HomeBook from '../../components/home/HomeBook'
  import Auth from '../../components/base/Auth'
  import {getHomeData, recommend, hotBook, freeRead, register} from '../../api'
  import {getSetting, getUserInfo, setStorageSync, getStorageSync, getUserOpenId, showLoading, hideLoading} from '../../api/wechat'

  export default {
    components: {
      HomeBook,
      HomeBanner,
      HomeCard,
      SearchBar,
      Auth
    },
    data() {
      return {
        hotSearch: '',
        homeCard: {},
        banner: {},
        recommend: [],
        freeRead: [],
        hotBook: [],
        category: [],
        isAuth: true
      }
    },
    methods: {
      onMemoClick() {
        this.$router.push({path: '/pages/memo/main'})
      },
      onWeatherClick() {
        this.$router.push({path: '/pages/weather/main'})
      },
      toUserInfoClick() {
        this.$router.push({path: '/pages/userInfo/main'})
      },
      recommendChange(key) {
        switch (key) {
          case 'recommend':
            recommend().then(response => {
              this.recommend = response.data.data
            })
            break
          case 'freeRead':
            freeRead().then(response => {
              this.freeRead = response.data.data
            })
            break
          case 'hotBook':
            hotBook().then(response => {
              this.hotBook = response.data.data
            })
            break
        }
      },
      onHomeBookClick(book) {
        console.log(book)
        this.$router.push({
          path: '/pages/detail/main',
          query: {
            fileName: book.fileName
          }
        })
      },
      onBookMoreClick() {
        console.log('more click')
      },
      onSearchBarClick() {
        console.log('1234')
      },
      onBannerClick() {
        console.log('跳转珠珠珠')
      },
      getHomeData(openId, userInfo) {
        getHomeData({ openId }).then(response => {
          const {
            data: {
              hotSearch: {
                keyword
              },
              shelf,
              banner,
              recommend,
              freeRead,
              hotBook,
              category,
              shelfCount
            }
          } = response.data
          console.log(keyword, shelf, banner, recommend, freeRead, hotBook, category, shelfCount)
          this.hotSearch = keyword
          this.banner = banner
          this.recommend = recommend
          this.freeRead = freeRead
          this.hotBook = hotBook
          this.category = category
          this.homeCard = {
            bookList: shelf,
            num: shelfCount,
            userInfo
          }
          hideLoading()
        }).catch(() => {
          hideLoading()
        })
      },
      getUserInfo() {
        const onOpenIdComplete = (openId, userInfo) => {
          this.getHomeData(openId, userInfo)
          register(openId, userInfo)
        }
        getUserInfo(
          (userInfo) => {
            console.log(userInfo)
            setStorageSync('userInfo', userInfo)
            const openId = getStorageSync('openId')
            if (!openId || openId.length === 0) {
              getUserOpenId((openId) => onOpenIdComplete(openId, userInfo))
            } else {
              onOpenIdComplete(openId, userInfo)
            }
          },
          () => {
            console.log('failed..') // 获取用户信息 抛出异常
          }
        )
      },
      getSetting() {
        getSetting(
          'userInfo',
          () => {
            this.isAuth = true
            showLoading('正在加载')
            this.getUserInfo()
          },
          () => {
            this.isAuth = false
          }
        )
      },
      init() {
        this.getSetting()
      }
    },
    mounted() {
      this.init()
    }
  }
</script>

<style lang="scss" scoped>
  .home {
    .personalInfo {
      position: absolute;
      right: 20px;
      top: 50px;
    }
  }
</style>
