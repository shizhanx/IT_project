<template>
  <div>
    <SearchBar
      :disabled="true"
      @onClick="onClickSearch"
    />
    <div class="calendar">
      <Calendar
        :months="months"
        :value="value"
        @next="next"
        @prev="prev"
        lunar
        clean
        @select="select"
        ref="calendar"
        @selectMonth="selectMonth"
        @selectYear="selectYear"
        :tileContent="tileContent"
        :almanacs="almanacs"
      />
    </div>
    <button class="control" @click="toInput" style="background-image:url(/static/images/18.png)" plain="true"></button>
    <div class="list">
      <div
        v-for="(event,i) in events"
        :key="i"
        @click='onClickEvent(event)'
      >
        <van-divider />
        <van-card
          :title=event.name
          :thumb=event.image
        />
      </div>
    </div>
  </div>
</template>

<script>
  import Calendar from 'mpvue-calendar'
  import 'mpvue-calendar/src/style.css'
  import {setStorageSync, getStorageSync} from '../../api/wechat'
  import SearchBar from '../../components/home/SearchBar'

  export default {
    data () {
      return {
        months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        disabledArray: ['2018-6-27', '2018-6-25'],
        value: [2019, 10, 1],
        begin: [2016, 1, 1],
        end: [2020, 1, 1],
        almanacs: {'11-17': '学生日'},
        tileContent: [
          {date: '2018-9-22', className: 'holiday ', content: '休'},
          {date: '2018-9-23', className: 'holiday ', content: '休'}
        ],
        events: {}
      }
    },
    components: {
      Calendar,
      SearchBar
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
      renderer () {
        this.$refs.calendar.renderer(2018, 8)
      },
      toInput () {
        wx.navigateTo({
          url: '/pages/userInput/main'
        })
      },
      select (val, val2) {
        setStorageSync('date_selected', val[0] * 10000 + val[1] * 100 + val[2])
        this.$httpWX.post({
          url: 'objects/event/search/date',
          data: {
            search: getStorageSync('date_selected')
          }
        }).then(res => {
          this.events = res
        })
      },
      onClickEvent (event) {
        setStorageSync('current_event', event)
        this.$router.push({path: '/pages/eventDetail/main'})
      },
      onClickSearch() {
        console.log('111')
        this.$router.push({path: '/pages/search/main'})
      }
    }
  }
</script>

<style>
  .control {
    position: fixed;
    z-index: 1000;
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

  .list {
    z-index: 0;
  }

  .calendar {
    position: relative;
    padding: 0px;
  }
</style>
