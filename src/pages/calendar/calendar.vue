<template>
  <div>
    <Calendar
      :months="months"
      :value="value"
      @next="next"
      @prev="prev"
      :events="events"
      lunar
      clean
      @select="select"
      ref="calendar"
      @selectMonth="selectMonth"
      @selectYear="selectYear"
      :tileContent="tileContent"
      :almanacs="almanacs"
    />
    <button @click="setToday">返回今日</button>
    <button @click="dateInfo">当日事件</button>
    <button class="control" @click="toInput" style="background-image:url(/static/images/18.png)" plain="true"></button>
    <div class="listContainer">
      <swiper indicator-dots indicator-color="pink" indicator-active-color="green">
        <swiper-item>
          <img @click="toDetail" src="/static/images/11.jpg" alt="">
        </swiper-item>
        <swiper-item>
          <img src="/static/images/22.jpg" alt="">
        </swiper-item>
        <swiper-item>
          <img src="/static/images/23.jpg" alt="">
        </swiper-item>
      </swiper>
    </div>
  </div>
</template>

<script>
  import Calendar from 'mpvue-calendar'
  import 'mpvue-calendar/src/style.css'

  export default {
    data () {
      return {
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        disabledArray: ['2018-6-27', '2018-6-25'],
        value: [2018, 6, 7],
        begin: [2016, 1, 1],
        end: [2020, 1, 1],
        events: {'2018-6-7': '今日备注', '2018-6-8': '一条很长的明日备注'},
        almanacs: {'11-17': '学生日'},
        tileContent: [
          {date: '2018-9-22', className: 'holiday ', content: '休'},
          {date: '2018-9-23', className: 'holiday ', content: '休'}
        ]
      }
    },
    components: {
      Calendar
    },
    methods: {
      prev (year, month, weekIndex) {
        console.log(year, month, weekIndex)
      },
      next (year, month, weekIndex) {
        console.log(year, month, weekIndex)
      },
      selectYear (year) {
        console.log(year)
      },
      selectMonth (month, year) {
        console.log(year, month)
      },
      setToday () {
        this.$refs.calendar.setToday()
      },
      dateInfo () {
        this.$router.push({path: '/pages/detail/main'})
        const info = this.$refs.calendar.dateInfo(2018, 8, 23)
        console.log(info)
      },
      renderer () {
        this.$refs.calendar.renderer(2018, 8)
      },
      toInput () {
        wx.navigateTo({
          url: '/pages/userInput/main'
        })
      },
      toDetail () {
        wx.navigateTo({
          url: '/pages/detail/main'
        })
      },
      select (val, val2) {
        console.log(val)
        console.log(val2)
      }
    }
  }
</script>

<style>
  .control {
    position: absolute;
    bottom: 40px;
    width: 34px;
    height: 34px;
    right: 30px;
    background-size: 34px 34px;
  }
  button.control[plain] {
    border: 0;
  }
  .listContainer swiper {
    width: 75%;
    height: 75%;
    height: 400rpx;
  }

  .listContainer swiper img {
    width: 100%;
    height: 100%;
  }
</style>
