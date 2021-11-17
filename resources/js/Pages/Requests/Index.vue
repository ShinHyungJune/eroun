<template>
    <div class="subContent area-workerList">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">섭외요청내역</h3>
                <p class="body">요청했던 내역들을 확인해보세요!</p>
            </div>

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
import Requests from "../../Components/Requests";
export default {
    components: {Requests},

    data() {
        return {
            requests: this.$page.props.requests,
            form: this.$inertia.form({
                page: 1
            }),
            loading: false,
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
                preserveState: true,
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
        }
    },

    mounted() {

    }
}
</script>
