<template>
  <div>
    <NavbarComp />
    <div class="container" style="margin-top: 100px; margin-bottom: 50px">
      <slot />
    </div>
  </div>
</template>

<script>
import NavbarComp from "@/components/NavbarComp.vue";
export default {
  name: "LayoutView",
  components: {
    NavbarComp,
  },
};
</script>

<style></style>
