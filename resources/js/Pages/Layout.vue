<template>
    <div>
        <header-vue />
        <div class="main">
            <slot />
        </div>
        <footer-vue/>
    </div>

</template>
<script>
import HeaderVue from "../Components/Header";
import FooterVue from "../Components/Footer";
export default {
    components: {HeaderVue, FooterVue}
}
</script>
