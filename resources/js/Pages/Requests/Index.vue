<template>
    <div class="subContent area-workerList">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">섭외요청내역</h3>
                <p class="body">요청했던 내역들을 확인해보세요!</p>
            </div>

            <div class="top">
                <div class="m-input-toggle type01">
                    <input type="checkbox" id="123" v-if="form.mine == 1" checked="checked" />
                    <input type="checkbox" id="" v-else />
                    <label for="" @click="toggleMine">내 섭외요청내역만 보기</label>
                </div>

                <Link href="/requests/create" class="m-btn type02" v-if="user.data.worker == 0">+ 의뢰하기</Link>
            </div>


            <div class="mt-20"></div>

            <div class="m-empty type01" v-if="requests.data.length === 0">
                데이터가 없습니다.
            </div>

            <requests :items="requests.data" v-else />

            <div class="m-btns type01 mt-80" v-if="requests.links.next">
                <button class="m-btn type01 bg-primary" @click="loadMore">더보기</button>
            </div>
        </div>
    </div>
</template>
<script>
import {Link} from "@inertiajs/inertia-vue";
import Requests from "../../Components/Requests";
export default {
    components: {Requests, Link},

    data() {
        return {
            requests: this.$page.props.requests,
            form: this.$inertia.form({
                page: 1,
                mine: this.$page.props.mine
            }),
            loading: false,
            user: this.$page.props.user
        }
    },

    methods: {
        loadMore(){
            if(!this.loading){
                this.form.page += 1;

                this.filter();
            }
        },

        filter(){
            let isLoadMore = this.requests.meta.current_page !== this.form.page;

            this.loading = true;

            if(!isLoadMore)
                this.form.page = 1;

            this.form.get("/requests", {
                preserveScroll: true,
                replace: true,
                onSuccess: (response) => {
                    this.loading = false;

                    if(isLoadMore) {
                        return this.requests = {
                            ...response.props.requests,
                            data: [...this.requests.data, ...response.props.requests.data]
                        }
                    }

                    return this.requests = response.props.requests;
                }
            });
        },

        toggleMine(){
            this.form.mine = this.form.mine == 1 ? 0 : 1;

            this.filter();
        },
    },

    mounted() {

    }
}
</script>
