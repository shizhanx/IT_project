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
        data1: [
          {
            'id': 34,
            'fileName': '2018_Book_GeographiesOfTheUniversity',
            'cover': 'https://www.youbaobao.xyz/book/res/img/Geography/978-3-319-75593-9_CoverFigure.jpg',
            'title': 'Geographies of the University',
            'author': 'Peter Meusburger',
            'publisher': 'Springer International Publishing',
            'bookId': '2018_Book_GeographiesOfTheUniversity',
            'category': 7,
            'categoryText': 'Geography',
            'language': 'en',
            'rootFile': 'OEBPS/package.opf'
          },
          {
            'id': 59,
            'fileName': '2018_Book_DrinkingInVictorianAndEdwardia',
            'cover': 'https://www.youbaobao.xyz/book/res/img/History/978-3-319-92964-4_CoverFigure.jpg',
            'title': 'Drinking in Victorian and Edwardian Britain',
            'author': 'Thora Hands',
            'publisher': 'Springer International Publishing',
            'bookId': '2018_Book_DrinkingInVictorianAndEdwardia',
            'category': 8,
            'categoryText': 'History',
            'language': 'en',
            'rootFile': 'OEBPS/package.opf'
          },
          {
            'id': 60,
            'fileName': '2018_Book_HarnessingThePowerOfTheCrimina',
            'cover': 'https://www.youbaobao.xyz/book/res/img/History/978-3-319-77908-9_CoverFigure.jpg',
            'title': 'Harnessing the Power of the Criminal Corpse',
            'author': 'Sarah Tarlow',
            'publisher': 'Springer International Publishing',
            'bookId': '2018_Book_HarnessingThePowerOfTheCrimina',
            'category': 8,
            'categoryText': 'History',
            'language': 'en',
            'rootFile': 'OEBPS/package.opf'
          },
          {
            'id': 75,
            'fileName': '2018_Book_TheEuropeanBloodAndMarrowTrans',
            'cover': 'https://www.youbaobao.xyz/book/res/img/MedicineAndPublicHealth/978-3-319-50026-3_CoverFigure.jpg',
            'title': 'The European Blood and Marrow Transplantation Textbook for Nurses',
            'author': 'Michelle Kenyon',
            'publisher': 'Springer International Publishing',
            'bookId': '2018_Book_TheEuropeanBloodAndMarrowTrans',
            'category': 17,
            'categoryText': 'MedicineAndPublicHealth',
            'language': 'en',
            'rootFile': 'OEBPS/package.opf'
          }
        ],
        data2: [
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Biomedicine/978-3-319-25474-6_CoverFigure.jpg',
            'category': 12,
            'categoryText': 'Biomedicine',
            'num': 14,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Biomedicine/978-3-319-72790-5_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/BusinessandManagement/978-3-319-33515-5_CoverFigure.jpg',
            'category': 13,
            'categoryText': 'BusinessandManagement',
            'num': 16,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/BusinessandManagement/978-3-319-95261-1_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/ComputerScience/978-3-319-90415-3_CoverFigure.jpg',
            'category': 1,
            'categoryText': 'ComputerScience',
            'num': 56,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/ComputerScience/978-3-319-96142-2_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/EarthSciences/978-981-10-3713-9_CoverFigure.jpg',
            'category': 14,
            'categoryText': 'EarthSciences',
            'num': 16,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/EarthSciences/978-3-319-65633-5_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Economics/978-3-319-69772-7_CoverFigure.jpg',
            'category': 3,
            'categoryText': 'Economics',
            'num': 30,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Economics/978-3-319-91400-8_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Education/978-3-319-39450-3_CoverFigure.jpg',
            'category': 4,
            'categoryText': 'Education',
            'num': 60,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Education/978-3-319-52980-6_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Engineering/978-3-319-91707-8_CoverFigure.jpg',
            'category': 5,
            'categoryText': 'Engineering',
            'num': 23,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Engineering/978-3-319-64816-3_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Environment/978-3-319-29671-5_CoverFigure.jpg',
            'category': 6,
            'categoryText': 'Environment',
            'num': 42,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Environment/978-4-431-54895-9_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Geography/978-3-319-75593-9_CoverFigure.jpg',
            'category': 7,
            'categoryText': 'Geography',
            'num': 7,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Geography/978-3-319-92813-5_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/History/978-3-319-64337-3_CoverFigure.jpg',
            'category': 8,
            'categoryText': 'History',
            'num': 18,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/History/978-3-319-92964-4_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Laws/978-3-319-71087-7_CoverFigure.jpg',
            'category': 9,
            'categoryText': 'Laws',
            'num': 13,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Laws/978-981-13-1232-8_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/LifeSciences/978-3-319-68152-8_CoverFigure.jpg',
            'category': 10,
            'categoryText': 'LifeSciences',
            'num': 24,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/LifeSciences/978-3-319-69539-6_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Literature/2010_Book_CyborgsInLatinAmerica.jpeg',
            'category': 11,
            'categoryText': 'Literature',
            'num': 6,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Literature/2010_Book_HistoryAndCulturalMemoryInNeo-.jpeg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/MaterialsScience/978-981-10-7617-6_CoverFigure.jpg',
            'category': 15,
            'categoryText': 'MaterialsScience',
            'num': 2,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/MaterialsScience/2018_Book_ProceedingsOfTheScientific-Pra.jpeg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Mathematics/978-3-319-29439-1_CoverFigure.jpg',
            'category': 16,
            'categoryText': 'Mathematics',
            'num': 9,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Mathematics/2015_Book_InnovationsInQuantitativeRiskM.jpeg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/MedicineAndPublicHealth/978-3-319-28624-2_CoverFigure.jpg',
            'category': 17,
            'categoryText': 'MedicineAndPublicHealth',
            'num': 20,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/MedicineAndPublicHealth/978-3-319-75019-4_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Philosophy/978-3-319-26300-7_CoverFigure.jpg',
            'category': 18,
            'categoryText': 'Philosophy',
            'num': 16,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Philosophy/978-3-319-94610-8_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Physics/978-3-319-42424-8_CoverFigure.jpg',
            'category': 19,
            'categoryText': 'Physics',
            'num': 10,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Physics/978-3-662-57366-2_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/PoliticalScienceAndInternationalRelations/978-3-319-69929-5_CoverFigure.jpg',
            'category': 20,
            'categoryText': 'PoliticalScienceAndInternationalRelations',
            'num': 26,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/PoliticalScienceAndInternationalRelations/978-981-10-7182-9_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Psychology/978-3-319-78160-0_CoverFigure.jpg',
            'category': 21,
            'categoryText': 'Psychology',
            'num': 3,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Psychology/2015_Book_PromotingSocialDialogueInEurop.jpeg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/SocialSciences/978-3-319-72356-3_CoverFigure.jpg',
            'category': 2,
            'categoryText': 'SocialSciences',
            'num': 51,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/SocialSciences/978-3-319-77991-1_CoverFigure.jpg'
          },
          {
            'cover': 'https://www.youbaobao.xyz/book/res/img/Statistics/2013_Book_ShipAndOffshoreStructureDesign.jpeg',
            'category': 22,
            'categoryText': 'Statistics',
            'num': 1,
            'cover2': 'https://www.youbaobao.xyz/book/res/img/Statistics/2013_Book_ShipAndOffshoreStructureDesign.jpeg'
          }
        ],
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
