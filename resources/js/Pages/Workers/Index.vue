<template>
    <div class="subContent area-workerList">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">전문가 목록</h3>
                <p class="body">이로운컴퍼니만의 전문가들을 소개합니다!</p>
            </div>

            <div class="m-input-checkboxes type01">
                <div class="m-input-checkbox type01">
                    <input type="checkbox" checked="checked" v-if="form.category_ids.length === 0">
                    <input type="checkbox" v-else>
                    <label for="" @click="clearCategories">전체</label>
                </div>
                <div class="m-input-checkbox type01" v-for="category in categories.data" :key="category.id" @change="filter">
                    <input type="checkbox" :id="category.id" :value="category.id" v-model.lazy="form.category_ids">
                    <label :for="category.id">{{ category.title }}</label>
                </div>
            </div>

            <div class="m-input-top type01">
                <div class="count">
                    총 <span class="primary">{{ workers.meta.total }}</span>명
                </div>

                <div class="inputs">
                    <div class="m-input-select type01">
                        <select name="" id="" v-model.lazy="form.orderBy" @change="filter">
                            <option value="count_request">인기순</option>
                            <option value="created_at">최신순</option>
                        </select>
                    </div>

                    <form @submit.prevent="filter">
                        <div class="m-input-text type01">
                            <input type="text" placeholder="전문가명" v-model.lazy="form.word">

                            <img src="/img/search.png" alt="" class="m-input-text-deco" @click="filter">
                        </div>
                    </form>
                </div>
            </div>

            <div class="m-empty type01" v-if="workers.data.length === 0">
                데이터가 없습니다.
            </div>

            <workers :items="workers.data" v-else />

            <div class="m-btns type01 mt-80" v-if="workers.links.next">
                <button class="m-btn type01 bg-primary" @click="loadMore">더보기</button>
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
            categories: this.$page.props.categories,
            form: this.$inertia.form({
                word: this.$page.props.word,
                orderBy: this.$page.props.orderBy,
                category_ids: this.$page.props.category_ids,
                page: 1
            }),
            loading: false,
        }
    },

    methods: {
        clearCategories(){
            this.form.category_ids = [];

            this.filter();
        },

        loadMore(){
            if(!this.loading){
                this.form.page += 1;

                this.filter();
            }
        },

        filter(){
            let isLoadMore = this.workers.meta.current_page !== this.form.page;

            this.loading = true;

            if(!isLoadMore)
                this.form.page = 1;

            this.form.get("/workers", {
                preserveScroll: true,
                preserveState: true,
                replace: true,
                onSuccess: (response) => {
                    this.loading = false;

                    if(isLoadMore) {
                        return this.workers = {
                            ...response.props.workers,
                            data: [...this.workers.data, ...response.props.workers.data]
                        }
                    }

                    return this.workers = response.props.workers;
                }
            });
        }
    },

    mounted() {

    }
}
</script>
