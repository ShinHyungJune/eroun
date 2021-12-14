<template>
    <div class="area-main">
        <div class="box-video" v-if="show">
            <img src="/img/logo.png" alt="" class="logo">

            <button class="btn-close" @click="show = false">
                <img src="/img/circleClose.png" alt="">
            </button>

            <video muted autoplay loop>
                <source src="/video/intro.mp4" type="video/mp4">
            </video>
        </div>

        <section class="section section01">
            <div class="swiper">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <Link href="/requests/create" class="swiper-slide pc" v-for="banner in banners.data" :key="banner.id">
                            <img :style="`background:url(${banner.pc ? banner.pc.url : ''}) no-repeat; background-size:cover;`" alt="" class="visual pc">
                            <img :style="`background:url(${banner.mobile ? banner.mobile.url : ''}) no-repeat; background-size:cover;`" alt="" class="visual m">
                        </Link>
                    </div>
                </div>

                <div class="swiper-btns">
                    <div class="swiper-btn swiper-btn-prev">
                        <img src="/img/arrowLeft-white.png" alt="">
                    </div>
                    <div class="swiper-btn swiper-btn-next">
                        <img src="/img/arrowLeft-white.png" alt="">
                    </div>
                </div>
                <div class="swiper-pagination"></div>
            </div>

            <div class="categories">
                <div class="wrap">
                    <Link :href="`/workers?category_ids[]=${category.id}`" class="category" v-for="category in categories.data" :key="category.id">
                        <div class="img-wrap">
                            <img :src="category.img ? category.img.url : ''" alt="">
                        </div>

                        <h3 class="title">{{category.title}}</h3>
                    </Link>
                </div>
            </div>
        </section>

        <section class="section section02">
            <div class="wrap">
                <div class="section-title">
                    <h3 class="title">인기 전문가</h3>

                    <Link :href="`/workers?orderBy=count_view`" class="btn-more">더보기 <img src="/img/arrowSmallRight-gray.png" alt=""></Link>
                </div>

                <workers :items="populatedWorkers.data" />
            </div>
        </section>

        <section class="section section03">
            <div class="wrap">
                <div class="section-title">
                    <h3 class="title">최근 활동한 전문가</h3>

                    <Link :href="`/workers?orderBy=updated_at`" class="btn-more">더보기 <img src="/img/arrowSmallRight-gray.png" alt=""></Link>
                </div>

                <workers :items="recentWorkers.data" />
            </div>
        </section>

        <section class="section section04">
            <div class="wrap">
                <div class="section-title">
                    <h3 class="title">신규 전문가</h3>

                    <Link :href="`/workers?orderBy=created_at`" class="btn-more">더보기 <img src="/img/arrowSmallRight-gray.png" alt=""></Link>
                </div>

                <workers :items="newWorkers.data" />
            </div>

        </section>

        <section class="section section05">
            <div class="wrap">
                <div class="boxes">
                    <div class="box-wrap">
                        <div class="box">
                            <h3 class="title">Professional</h3>

                            <div class="content">
                                <h3 class="title">등록된 전문가</h3>
                                <p class="body">
                                    <span class="point">{{ counts.workers }}</span>명
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="box-wrap">
                        <div class="box">
                            <h3 class="title">Request</h3>

                            <div class="content">
                                <h3 class="title">누적 의뢰</h3>
                                <p class="body">
                                    <span class="point">{{ counts.requests }}</span>건
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <section class="section section06">
            <div class="wrap">
                <div class="section-title">
                    <h3 class="title">행사/이벤트</h3>

                    <Link href="/events" class="btn-more">더보기 <img src="/img/arrowSmallRight-gray.png" alt=""></Link>
                </div>

                <events :items="events.data" />
            </div>

        </section>

        <section class="section07">
            <div class="wrap">
                <div class="section-title">
                    <h3 class="title"><span class="point">서비스명</span>과 함께한 <br class="m">고객사들의 리얼 후기!</h3>
                </div>
            </div>

            <div class="swiper">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide" v-for="company in companies.data" :key="company.id">
                            <div class="content">
                                <div class="m-ratioBox-wrap">
                                    <div class="m-ratioBox">
                                        <img :src="company.img ? company.img.url : ''" alt="">
                                    </div>
                                </div>

                                <h3 class="title">
                                    {{company.title}}
                                </h3>

                                <p class="body">
                                    {{company.description}}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>
<script>
import {Link} from "@inertiajs/inertia-vue";
import Workers from "../Components/Workers";
import Events from "../Components/Events";

export default {
    components: {Link, Workers, Events},

    data() {
        return {
            banners: this.$page.props.banners,
            categories: this.$page.props.categories,
            populatedWorkers: this.$page.props.populatedWorkers,
            recentWorkers: this.$page.props.recentWorkers,
            newWorkers: this.$page.props.newWorkers,
            counts: this.$page.props.counts,
            events: this.$page.props.events,
            companies: this.$page.props.companies,
            show: this.$page.props.show == "false" ? false : true
        }
    },

    methods: {

    },

    mounted(){
        console.log(this.$page.props.show);
        new Swiper('.section01 .swiper .swiper-container', {
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            loop: true,
            pagination: {
                el: '.section01 .swiper .swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.section01 .swiper .swiper-btn-next',
                prevEl: '.section01 .swiper .swiper-btn-prev',
            },
        });

        new Swiper('.section07 .swiper .swiper-container', {
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            centeredSlides: true,
            slidesPerView: 3.5,
            spaceBetween: 40,
            loop: true,
            pagination: {
                el: '.section07 .swiper .swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.section07 .swiper .swiper-btn-next',
                prevEl: '.section07 .swiper .swiper-btn-prev',
            },
            breakpoints: {
                1200: {
                    slidesPerView: 2.5
                },
                768: {
                    spaceBetween: 10,
                    slidesPerView: 1.2
                }
            }
        });
    }
}
</script>
