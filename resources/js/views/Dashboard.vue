<template>
    <div>
        <!-- Navigation-->
        <Header/>
        <div class="content-wrapper">
            <router-view></router-view>

            <Footer/>

        </div>

    </div>

</template>

<script>
import Header from "../components/Header"
import Footer from "../components/Footer";

export default {
    components: {Footer, Header}
}
</script>
