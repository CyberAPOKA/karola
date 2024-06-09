import { ref } from "vue";
const isLargeScreen = window.innerWidth > 640;
export const sidebarVisible = ref(isLargeScreen);
export const sidebarExpanded = ref(window.innerWidth < 640);