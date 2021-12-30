<template>
    <div class="items type04">
        <div class="item" v-for="item in items" :key="item.id">
            <h3 class="title">{{item.title}}</h3>

            <p class="body" style="margin-bottom:10px;">{{item.description}}</p>

            <p class="contact" style="margin-bottom:40px; text-decoration: underline; color:#5E9CCB">{{phone(item.contact)}}</p>

            <div class="btns">
                <Link :href="`/workers/${item.user_id}`" class="m-btn type02">전문가 보기</Link>
                <button type="button" @click="select(item)" class="m-btn type02 bg-primary" v-if="user && user.id === request.user_id">
                    {{item.selected ? "확정완료" : "섭외 확정하기"}}
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    import {Link} from "@inertiajs/inertia-vue";

    export default {
        components: {Link},
        props: ["items", "request"],
        data(){
            return {
                user: this.$page.props.user.data,
                form: this.$inertia.form({
                    "request_id" : this.request.id
                })
            }
        },
        methods:{
            select(item){
                this.form.patch("/applications/select/" + item.id, {
                    preserveScroll: true,
                    preserveState: false,
                    onSuccess: (response) => {
                        if (response.props.flash.error)
                            alert(response.props.flash.error);

                        if (response.props.flash.success)
                            alert(response.props.flash.success);

                    }
                });
            },
            phone(num, type = 1){
                var formatNum = '';



                if(num.length==11){

                    if(type==0){

                        formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, '$1-****-$3');

                    }else{

                        formatNum = num.replace(/(\d{3})(\d{4})(\d{4})/, '$1-$2-$3');

                    }

                }else if(num.length==8){

                    formatNum = num.replace(/(\d{4})(\d{4})/, '$1-$2');

                }else{

                    if(num.indexOf('02')==0){

                        if(type==0){

                            formatNum = num.replace(/(\d{2})(\d{4})(\d{4})/, '$1-****-$3');

                        }else{

                            formatNum = num.replace(/(\d{2})(\d{4})(\d{4})/, '$1-$2-$3');

                        }

                    }else{

                        if(type==0){

                            formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, '$1-***-$3');

                        }else{

                            formatNum = num.replace(/(\d{3})(\d{3})(\d{4})/, '$1-$2-$3');

                        }

                    }

                }

                return formatNum;
            }
        },
        computed() {
            return {

            }

        }
    }
</script>
