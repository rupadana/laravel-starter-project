<template>
  <PFrame>
    <PTopBar
      :onNavigationToggle="toggleSidebar"
      @click="toggleSidebar"
      slot="topBar"
      showNavigationToggle
      :logo="{
        width: 124,
        topBarSource:
          'https://cdn.shopify.com/s/files/1/1564/7647/files/hulk-apps-darken_c0448e92-587f-47a8-9473-5ea0023b5ffd.svg?v=1583731462',
        url: 'javascript:void(0)',
        accessibilityLabel: 'Hulkapps',
      }"
      :userMenu="{
        id: 'Polaris-UserMenu',
        actions: [
          { items: [{ content: 'Back to Shopify', icon: 'ArrowLeftMinor' }] },
          { items: [{ content: 'Community forums' }] },
        ],
        name: 'Dharma',
        detail: 'Hulkapps',
        initials: 'D',
        open: isOpen,
        onToggle: toggle,
        message: {
          title: 'Shopify Production',
          description: 'New message',
          action: { content: 'Action' },
          link: { to: 'javascript:void(0);', content: 'Link', external: true },
          badge: { content: 'Badge', status: 'warning' },
        },
      }"
    />

    <PStack vertical="">
      <PToggle
        :label="permission.name"
        @change="(v) => valueChange(v, i)"
        v-for="(permission, i) in permissions"
        :key="i"
        :checked="permission.value"
      />
    </PStack>
  </PFrame>
</template>

<script>
export default {
  data() {
    return {
      permissions: [
        {
          name: "can write",
          value: true,
        },
        {
          name: "can update",
          value: false,
        },
      ],
      valueKu: false,
      isOpen: false,
      modalMarkup: {
        modalActive: false,
      },
      mobileNavigationActive: true,
      logoMarkup: {
        width: 124,
        contextualSaveBarSource:
          "https://cdn.shopify.com/s/files/1/1564/7647/files/hulk-apps-darken_c0448e92-587f-47a8-9473-5ea0023b5ffd.svg?v=1583731462",
        url: "javascript:void(0)",
        accessibilityLabel: "Hulkapps",
      },
      userMenu: {
        id: "Polaris-UserMenu",
        actions: [
          { items: [{ content: "Back to Shopify", icon: "ArrowLeftMinor" }] },
          { items: [{ content: "Community forums" }] },
        ],
        name: "Dharma",
        detail: "Hulkapps",
        initials: "D",
        open: true,
        onToggle: this.toggle,
        message: {
          title: "Shopify Production",
          description: "New message",
          action: { content: "Action" },
          link: { to: "javascript:void(0);", content: "Link", external: true },
          badge: { content: "Badge", status: "warning" },
        },
      },
    };
  },

  methods: {
    toggleSidebar() {
      console.log("hello");
    },
    toggle() {
      this.isOpen = !this.isOpen;
    },
    handleSave() {
      console.log("Saved");
    },
    handleDiscard() {
      console.log("Discarded");
    },
    valueChange(target, i) {
      this.permissions[i].value = target.checked;
    },
  },
  mounted() {
    // var popElement = document.querySelectorAll(
    //   "#PolarisPopoverPolaris-UserMenuOverlay"
    // );
    // document.addEventListener("click", (event) => {
    //   for (let i = 0; i < popElement.length; i++) {
    //     let popEl = popElement[i];
    //     var isClickInside = popEl.contains(event.target);
    //     if (!isClickInside) {
    //       console.log("Outside");
    //       this.isOpen = !this.isOpen;
    //       break;
    //     } else {
    //       console.log("Inside");
    //     }
    //   }
    // });
  },
};
</script>

<style>
</style>