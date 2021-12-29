<template>
    <div class="subContent area-requestCreate">
        <div class="wrap">
            <div class="section-title type01">
                <h3 class="title">지원서 작성</h3>
                <p class="body">작성해주신 내용을 토대로 지원서가 전달됩니다!</p>
            </div>

            <form class="form type01" @submit.prevent="store">
                <div class="m-input-wrap type01" style="margin-bottom:10px; padding-bottom:0; border-bottom:none;">
                    <div class="m-input-title">한줄 소개(타이틀)</div>

                    <div class="m-input-text type01">
                        <input type="text" placeholder="예) 트렌디한 웃음사냥꾼 이찬혁입니다!" v-model="form.title" />
                    </div>

                    <p class="m-input-error" v-if="form.errors.title">{{form.errors.title}}</p>
                </div>

                <div class="m-input-wrap type01" style="margin-bottom:10px; padding-bottom:0; border-bottom:none;">
                    <div class="m-input-title">더 전달해주실 내용이 있나요?</div>

                    <div class="m-input-textarea type01">
                        <textarea name="" id="" placeholder="예) 저는 돌잔치 행사를 100회 이상 진행한 이력이 있고..." v-model="form.description"></textarea>
                    </div>

                    <p class="m-input-error" v-if="form.errors.comment">{{form.errors.description}}</p>

                </div>

                <div class="m-btns type01">
                    <button class="m-btn type01 bg-down width-100">지원하기</button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return {
            form: this.$inertia.form({
                request_id: this.$page.props.request_id,
                description: "",
                title: ""
            }),
        }
    },

    methods: {
        store(){
            this.form.post("/applications", {
                replace: true,
                onSuccess: (response) => {
                    if(response.props.flash.error)
                        alert(response.props.flash.error);

                    if(response.props.flash.success)
                        alert(response.props.flash.success);
                }
            });
        },
    },

    mounted() {

    }
}
</script>
