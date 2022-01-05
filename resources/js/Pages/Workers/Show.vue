<template>
    <div class="subContent area-workerDetail">
        <div class="section-title type02">
            <div class="wrap">
                <h3 class="title">"{{ worker.name }}" 전문가님의  상세정보를 확인해보세요!</h3>
                <div class="infos">
                    <p class="info">등록일 : {{ worker.created_at }}</p>
                    <p class="info">조회수 : {{ worker.count_view }}</p>
                </div>
            </div>
        </div>

        <div class="wrap">
            <div class="detail type01">
                <div class="m-ratioBox-wrap">
                    <div class="m-ratioBox">
                        <img :src="worker.img ? worker.img.url : ''" alt="">
                    </div>
                </div>

                <div class="content">
                    <h3 class="title">{{ worker.name }}</h3>
                    <div class="infos">
                        <div class="info">
                            <div class="info-title">카테고리</div>
                            <p class="info-body">{{worker.categories.length !== 0 ? worker.categories[0].title : '-'}}</p>
                        </div>
                        <div class="info">
                            <div class="info-title">경력</div>
                            <p class="info-body">{{ worker.career ? worker.career : "-" }}</p>
                        </div>
                        <div class="info">
                            <div class="info-title">평점</div>
                            <p class="info-body">{{ worker.score ? worker.score : "-" }}</p>
                        </div>
                        <div class="info">
                            <div class="info-title">섭외수</div>
                            <p class="info-body">{{ worker.count_request }}</p>
                        </div>
                    </div>

                    <div class="m-btns">
                        <Link :href="`/reviews/create?worker_id=${worker.id}`" class="m-btn type02">리뷰 작성</Link>
                        <Link :href="`/requests/create?worker_id=${worker.id}`" class="m-btn type01 bg-primary">섭외 문의</Link>
                    </div>
                </div>
            </div>

            <div class="section type01">
                <h3 class="section-title">전문가 소개</h3>

                <div class="m-empty type01" v-if="!worker.description" style="border:none;">
                    내용이 없습니다.
                </div>
                <div class="body" v-html="worker.description"></div>
            </div>

            <div class="section type01">
                <h3 class="section-title">고객님들의 리뷰</h3>

                <div class="m-empty type01" v-if="reviews.data.length === 0" style="border:none;">
                    리뷰가 없습니다.
                </div>
                <reviews :items="reviews.data" />
            </div>

        </div>
    </div>
</template>
<script>
import {Link} from "@inertiajs/inertia-vue";
import Reviews from "../../Components/Reviews";
export default {
    components: {Link, Reviews},

    data() {
        return {
            worker: this.$page.props.worker.data,
            reviews: this.$page.props.reviews
        }
    },

    methods: {

    },
}
</script>
