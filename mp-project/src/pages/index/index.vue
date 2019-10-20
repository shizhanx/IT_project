<template>
  <div>
    <div class="home">
      <div class="personalInfo">
        <van-button round type="info" @click="toUserInfoClick">修改个人信息</van-button>
      </div>
      <div class="familyInfo">
        <van-button round type="info" @click="toFamilyInfoClick">修改家族信息</van-button>
      </div>
      <div class="home-card">
        <div class="home-card-inner">
          <div class="user-info">
            <div class="avatar-wrapper" @click="onClickUser(current_user.name)">
              <ImageView
                :src=current_user.image
                round
                height="100%"
                mode="scaleToFill"
              />
            </div>
            <div class="nickname" @click="onClickUser(current_user.name)">{{current_user.name}}</div>
            <div class="shelf-text">你总共参与了{{total_events}}个活动</div>
            <div class="round-item"></div>
            <div class="shelf-text">最近活动：</div>
          </div>
          <div class="book-info">
            <div class="book-wrapper" @click="onClickEvent(recent_event)">
              <ImageView
                :src=recent_event.image
              />
              <div>{{recent_event.name}}</div>
            </div>
            <div class="shelf-wrapper">
              <div class="shelf" @click="onClickAll">全部</div>
              <van-icon
                class="arrow"
                name="arrow"
                size="11px"
                color="#828489"
              ></van-icon>
            </div>
          </div>
          <div class="feedback-wrapper"></div>
        </div>
      </div>
      <van-divider />
      <van-grid>
        <van-grid-item icon="notes-o" text="备忘录" @click="onMemoClick"/>
        <van-grid-item icon="https://www.easyicon.net/api/resizeApi.php?id=1221640&size=128" text="天气" @click="onWeatherClick"/>
        <van-grid-item icon="diamond-o" text="家族座右铭" url="https://www.baidu.com/"/>
        <van-grid-item icon="like-o" text="悄悄话" />
      </van-grid>
      <van-divider />
      <div v-if="have_future_events==='0'">没有计划开展的活动</div>
      <div v-if="have_future_events==='1'">
        <div>未来计划开展的活动</div>
        <swiper indicator-dots indicator-color="pink" indicator-active-color="green">
          <swiper-item v-for="(event,i) in future_events" :key="i" @click="onClickEvent(event)">
            <div>{{event.name}}</div>
            <img :src="event.image" alt="">
          </swiper-item>
        </swiper>
      </div>
    </div>
  </div>
</template>

<script>
  import HomeBanner from '../../components/home/HomeBanner'
  import ImageView from '../../components/base/ImageView'
  import {getStorageSync, setStorageSync} from '../../api/wechat'

  export default {
    components: {
      HomeBanner,
      ImageView
    },
    data() {
      return {
        current_user: getStorageSync('current_user'),
        total_events: 0,
        recent_event: {},
        future_events: {},
        have_future_events: '0'
      }
    },
    computed: {
      bgImage() {
        return 'url(' + this.recent_event['image'] + ')'
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
      toFamilyInfoClick() {
        this.$router.push({path: '/pages/familyInfo/main'})
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
      onBannerClick() {
        console.log('跳转珠珠珠')
      },
      onClickAll() {
        this.$router.push({path: '/pages/allEvents/main'})
      },
      onClickEvent(event) {
        setStorageSync('current_event', event)
        this.$router.push({path: '/pages/eventDetail/main'})
      },
      onClickUser(name) {
        setStorageSync('view_user', name)
        this.$router.push({path: '/pages/userDetail/main'})
      }
    },
    onShow() {
      var eventName
      this.$httpWX.post({
        url: 'relation/mysearch/userevent',
        data: {
          search_by: 'user',
          value: this.current_user['name']
        }
      }).then(res => {
        this.total_events = res.length
        if (res[0]) {
          eventName = res[res.length - 1]['event']
          this.$httpWX.post({
            url: 'objects/event/search/exact',
            data: {
              search: eventName
            }
          }).then(res => {
            if (res[0]) {
              this.recent_event = res[0]
            }
          })
        }
      })
      this.$httpWX.post({
        url: 'objects/event/searchFutureEvents',
        data: {
          today: 20191021
        }
      }).then(res => {
        if (res[0]) {
          this.have_future_events = '1'
        } else {
          this.have_future_events = '0'
        }
        this.future_events = res
      })
    }
  }
</script>

<style lang="scss" scoped>
  .home {
    .personalInfo {
      z-index: 1000;
      position: relative;
      right: -220px;
      top: 10px;
    }
    .familyInfo {
      position: relative;
      right: -20px;
      top: -40px;
    }
    .home-banner {
      margin-top: 20px;
      padding: 0 20px;
      box-sizing: border-box;
      .bg-img {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        height: 125px;
        border-radius: 10px;
        background-size: 100% 100%;
        background-repeat: no-repeat;
        .title {
          font-size: 18px;
          font-weight: 500;
          color: #fff;
        }
        .sub-title {
          padding: 5px 15px;
          background: #4585ff;
          border: 1px solid #ccc;
          border-radius: 50px;
          margin-top: 10px;
          font-size: 14px;
          color: #fff;
        }
      }
    }
    .home-card {
      background-image: linear-gradient(-90deg, #54575F 0%, #595B60 100%);
      border-radius: 15px;
      margin: 22px 20px 0;
      .home-card-inner {
        position: relative;
        padding: 21.5px 17px 20px 20px;
        box-sizing: border-box;
        .user-info {
          display: flex;
          align-items: center;
          .avatar-wrapper {
            width: 20px;
            height: 20px;
          }
          .nickname, .shelf-text {
            font-size: 12px;
            color: #fff;
          }
          .nickname {
            margin: 0 8.5px;
          }
          .round-item {
            width: 4px;
            height: 4px;
            background: #a2a2a2;
            border-radius: 50%;
            margin: 0 8px;
          }
        }
        .book-info {
          display: flex;
          margin-top: 16.5px;
          .book-wrapper {
            flex: 1;
            display: flex;
            justify-content: space-around;
            .book-img-wrapper {
              width: 72px;
              height: 101px;
            }
          }
          .shelf-wrapper {
            display: flex;
            align-items: center;
            .shelf {
              width: 11px;
              font-size: 11px;
              word-break: break-word;
              color: #fff;
              opacity: .8;
            }
          }
        }
        .feedback-wrapper {
          position: absolute;
          right: 0;
          top: 19.5px;
          width: 44.5px;
          height: 23.5px;
          background: #707070;
          opacity: .3;
          border-radius: 100px 0 0 100px;
        }
        .feedback-text {
          position: absolute;
          right: 0;
          top: 19.5px;
          width: 44.5px;
          height: 23.5px;
          line-height: 23.5px;
          text-align: center;
          color: #fff;
          font-size: 11px;
        }
      }
    }
  }
</style>
