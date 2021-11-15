<template>
    <div class="subContent area-workerList">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">전문가 목록</h3>
                <p class="body">이로운컴퍼니만의 전문가들을 소개합니다!</p>
            </div>

            <div class="m-input-checkboxes type01">
                <div class="m-input-checkbox type01">
                    <input type="checkbox" id="all" value="">
                    <label for="all">전체</label>
                </div>
                <div class="m-input-checkbox type01" v-for="category in categories.data" :key="category.id">
                    <input type="checkbox" :id="category.id" :value="category.id">
                    <label :for="category.id">{{ category.name }}</label>
                </div>
            </div>

            <div class="m-input-top type01">
                <div class="count">
                    총 <span class="primary">{{ workers.meta.total }}</span>명
                </div>

                <div class="inputs">
                    <div class="m-input-select type01">
                        <select name="" id="" v-model="form.orderBy">
                            <option value="count_view">인기순</option>
                            <option value="created_at">최신순</option>
                        </select>
                    </div>

                    <div class="m-input-text type01">
                        <input type="text" placeholder="전문가명" v-model="form.word">

                        <img src="/img/search.png" alt="" class="m-input-text-deco">
                    </div>
                </div>
            </div>

            <workers :items="workers" />

            <div class="m-btns type01 mt-80">
                <button class="m-btn type01 bg-primary">더보기</button>
            </div>
        </div>
    </div>
</template>
<script>
import Workers from "../../Components/Workers";
export default {
    components: {Workers},

    data() {
        return {
            workers: this.$page.props.workers,
            categories: this.$page.props.categories
        }
    },

    methods: {

    },

    mounted(){

    }
}
</script>
