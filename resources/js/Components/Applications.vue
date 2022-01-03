<template>
    <div class="table-wrap">
        <table class="m-table type01">
            <colgroup>
                <col style="width:15%">
                <col style="width:15%">
                <col style="width:20%">
                <col style="width:40%">
                <col style="width:10%">
            </colgroup>
            <thead>
            <tr>
                <th>전문가</th>
                <th>연락처</th>
                <th>제목</th>
                <th>지원내용</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            <tr v-for="item in items" :key="item.id">
                <td>
                    <a :href="`/workers/${item.user_id}`">{{ item.user_name }}</a>
                </td>
                <td>
                    {{phone(item.contact)}}
                </td>
                <td>
                    {{item.title}}
                </td>
                <td>
                    {{item.description}}
                </td>
                <td>
                    <button type="button" @click="select(item)" class="m-btn type02 bg-primary" v-if="user && user.id === request.user_id">
                        {{item.selected ? "확정완료" : "섭외 확정하기"}}
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
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
