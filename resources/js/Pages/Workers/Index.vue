<template>

</template>
<script>
export default {
    data() {
        return {
            contactForm: this.$inertia.form({
                "first_name" : null,
                "last_name": null,
                "phone": null,
                "email": null,
                "interest" : "",
                "comment" : null,
                "checked" : null
            })
        }
    },

    methods: {
        submitContact(){
            this.contactForm.post("/contacts", {
                preserveScroll: true,
                onSuccess: (response) => {
                    alert(response.props.flash.success);

                    this.contactForm.reset()
                }
            })
        }
    },

    mounted(){
        AOS.init();

        let swiper = new Swiper('.section06 .swiper-container', {
            spaceBetween: 60,
            centeredSlides: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            loop: true,
            slidesPerView: 3,
            navigation: {
                nextEl: '.section06 .swiper-btn-next',
                prevEl: '.section06 .swiper-btn-prev',
            },
            breakpoints: {
                1200: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 1.2,
                    spaceBetween: 20
                }
            }
        });
    }
}
</script>
