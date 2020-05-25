<template>
  <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
    <div class="navbar-brand-wrapper d-flex justify-content-center">
      <div
        class="navbar-brand-inner-wrapper d-flex justify-content-between align-items-center w-100"
      >
        <a class="navbar-brand brand-logo" href="index.html">
          <img src="/images/logo.png" alt="logo" />
          <span>Admin</span>
        </a>
        <a class="navbar-brand brand-logo-mini" href="index.html">
          <img src="/images/mobile-logo.png" alt="logo" />
        </a>
      </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
      <ul class="navbar-nav navbar-nav-right">
        <li class="nav-item dropdown mr-4">
          <a
            class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown"
            id="notificationDropdown"
            href="#"
            data-toggle="dropdown"
          >
            <i class="mdi mdi-bell mx-0"></i>
            <span class="count">{{ unReadNotifications.length }}</span>
          </a>
          <div
            class="dropdown-menu dropdown-menu-right navbar-dropdown"
            aria-labelledby="notificationDropdown"
          >
            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
            <div
              @click="readNotification(notification)"
              class="dropdown-item"
              v-for="notification in unReadNotifications"
              :key="notification.id"
            >
              <div class="item-thumbnail">
                <div class="item-icon bg-success">
                  <i class="mdi mdi-information mx-0"></i>
                </div>
              </div>
              <div class="item-content">
                <h6
                  class="font-weight-normal"
                >
                  New {{ notification.data.newJob.title }} job has been created!
                </h6>
                <span class="font-weight-normal">{{ notification.data.newJob.company }}</span>
                <p
                  class="font-weight-light small-text mb-0 text-muted"
                >{{ notification.created_at }}</p>
              </div>
            </div>
          </div>
        </li>
        <li class="nav-item nav-profile dropdown" v-if="user">
          <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
            <img src="/images/larissagideon.jpg" alt="profile" />
            <span class="nav-profile-name">{{ user.name }}</span>
          </a>
          <div
            class="dropdown-menu dropdown-menu-right navbar-dropdown"
            aria-labelledby="profileDropdown"
          >
            <a class="dropdown-item">
              <i class="mdi mdi-settings text-primary"></i>
              Settings
            </a>
            <router-link :to="{ name: 'profile' }" class="dropdown-item">
              <i class="mdi mdi-settings text-primary"></i>
              Profile
            </router-link>
            <a class="dropdown-item" @click="logout">
              <i class="mdi mdi-logout text-primary"></i>
              Logout
            </a>
          </div>
        </li>
      </ul>
      <div v-if="showPopOut === false">
        <button
          class="navbar-toggler navbar-toggler align-self-center"
          type="button"
          v-on:click="setShowPopOut()"
        >
          <span class="mdi mdi-sort-variant"></span>
        </button>
      </div>
      <div v-if="showPopOut === true">
        <button
          class="navbar-toggler navbar-toggler align-self-center"
          type="button"
          v-on:click="hideNav()"
        >
          <span class="mdi mdi-close"></span>
        </button>
      </div>
    </div>
  </nav>
</template>

<script>
  import { EventBus } from "../../event-bus";
  import { FS_CONFIG } from "../../config.js";
  import { authHeader } from "../../authHelper";

  export default {
    props: [
      'user',
      'isLoggedIn'
    ],
    data: () => ({
      allNotifications: [],
    }),
    created() {
      this.allNotifications = this.user.notifications;
    },
    computed: {
      unReadNotifications() {
        return this.allNotifications.filter(notification => {
          return notification.read_at == null;
        });
      },
      showPopOut() {
        return this.$store.getters.getShowPopOut;
      },
    },
    methods: {
      /*
        Toggles the showing and hiding of the popout menu.
      */
      setShowPopOut() {
        this.$store.dispatch("toggleShowPopOut", { showPopOut: true });
        let side = document.getElementById("sidebar");
        side.classList.add("active");
      },
      hideNav() {
        this.$store.dispatch("toggleShowPopOut", { showPopOut: false });
        let side = document.getElementById("sidebar");
        side.classList.remove("active");
      },
      logout: function() {
        this.$store.dispatch("logout").then(() => {
          this.$router.push("/login");
        });
      },
      readNotification(notification) {
        const jobID = notification.data.newJob.id
        const notifyID = notification.id
        const requestOptions = {
          headers: { ...authHeader()}
        };

        this.$router.push({name: 'editjob', params: { id: jobID }});

        axios.get(FS_CONFIG.API_URL + '/notifications/mark-as-read/' + notifyID, requestOptions)
        .then(response => {
          console.log(response)
        });
      },
    }
  };
</script>

<style scoped>
  .navbar {
    font-weight: 400;
    transition: background 0.25s ease;
  }
  .p-0 {
    padding: 0 !important;
  }
  .d-flex,
  .navbar .navbar-menu-wrapper .navbar-nav,
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item
    .item-thumbnail
    .item-icon,
  .navbar .navbar-menu-wrapper .navbar-nav.navbar-nav-right .nav-item {
    display: flex !important;
  }
  .navbar .navbar-brand-wrapper {
    background: #ffffff;
    border-bottom: 1px solid #e3e3e3;
    transition: width 0.25s ease, background 0.25s ease;
    width: 257px;
    height: 60px;
    border-right: 1px solid #e3e3e3;
  }
  .justify-content-center,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item
    .item-thumbnail
    .item-icon {
    justify-content: center !important;
  }
  .navbar .navbar-brand-wrapper .navbar-brand-inner-wrapper {
    margin-left: 1.375rem;
    margin-right: 1.375rem;
  }
  .w-100 {
    width: 100% !important;
  }
  .align-items-center,
  .navbar .navbar-menu-wrapper .navbar-nav,
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-settings,
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item
    .item-thumbnail
    .item-icon,
  .navbar .navbar-menu-wrapper .navbar-nav.navbar-nav-right .nav-item {
    align-items: center !important;
  }

  .justify-content-between {
    justify-content: space-between !important;
  }
  .navbar .navbar-brand-wrapper .navbar-brand-inner-wrapper .navbar-brand {
    color: #27367f;
    font-size: 1.5rem;
    margin-right: 0;
    padding: 0.25rem 0;
  }
  .btn,
  .btn-group.open .dropdown-toggle,
  .btn:active,
  .btn:focus,
  .btn:hover,
  .btn:visited,
  a,
  a:active,
  a:checked,
  a:focus,
  a:hover,
  a:visited,
  body,
  button,
  button:active,
  button:hover,
  button:visited,
  div,
  input,
  input:active,
  input:focus,
  input:hover,
  input:visited,
  select,
  select:active,
  select:focus,
  select:visited,
  textarea,
  textarea:active,
  textarea:focus,
  textarea:hover,
  textarea:visited {
    -webkit-box-shadow: none;
    -moz-box-shadow: none;
    box-shadow: none;
  }
  .navbar-brand {
    display: inline-block;
    padding-top: 0.3125rem;
    padding-bottom: 0.3125rem;
    margin-right: 1rem;
    font-size: 1.25rem;
    line-height: inherit;
    white-space: nowrap;
  }
  a,
  div,
  h1,
  h2,
  h3,
  h4,
  h5,
  p,
  span {
    text-shadow: none;
  }
  .navbar .navbar-brand-wrapper .navbar-brand-inner-wrapper .navbar-brand img {
    width: calc(257px - 150px);
    max-width: 100%;
    height: 100%;
    margin: auto;
    vertical-align: middle;
  }
  .navbar-brand-inner-wrapper .navbar-brand.brand-logo-mini {
    display: none;
  }
  .navbar .navbar-brand-wrapper .navbar-brand-inner-wrapper .brand-logo-mini {
    padding-left: 0;
    text-align: center;
  }
  .navbar .navbar-brand-wrapper .navbar-brand-inner-wrapper .brand-logo-mini img {
    width: calc(70px - 30px);
    max-width: 100%;
    margin: auto;
  }
  .navbar .navbar-brand-wrapper .navbar-brand-inner-wrapper .navbar-toggler {
    border: 0;
    color: #4a4a4a;
    font-size: 1.5rem;
    padding: 0;
  }
  .navbar .navbar-menu-wrapper {
    background: #ffffff;
    transition: width 0.25s ease;
    -webkit-transition: width 0.25s ease;
    -moz-transition: width 0.25s ease;
    -ms-transition: width 0.25s ease;
    color: #9b9b9b;
    padding-left: 1.062rem;
    padding-right: 1.062rem;
    width: calc(100% - 257px);
    height: 60px;
    border-bottom: 1px solid #e3e3e3;
  }
  .flex-row,
  .navbar .navbar-menu-wrapper .navbar-nav {
    flex-direction: row !important;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-search {
    margin-left: 0rem;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item:last-child {
    margin-right: 0;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item {
    margin-left: 1rem;
    margin-right: 1rem;
  }
  .w-100 {
    width: 100% !important;
  }
  .d-none,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav.navbar-nav-right
    .nav-item.nav-settings {
    display: none !important;
  }
  ul li,
  ol li,
  dl li {
    line-height: 1.8;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-search .input-group {
    background: #ececec;
    border-radius: 4px;
    padding: 0 0.75rem;
  }
  .navbar
    .navbar-brand-wrapper
    .navbar-brand-inner-wrapper
    .navbar-brand.brand-logo-mini {
    display: none;
  }
  .input-group {
    position: relative;
    display: flex;
    flex-wrap: wrap;
    align-items: stretch;
    width: 100%;
  }
  .input-group-append,
  .input-group-prepend {
    color: #c9c8c8;
    width: auto;
    border: none;
  }
  .input-group-prepend {
    margin-right: -1px;
  }
  .input-group-prepend,
  .input-group-append {
    display: flex;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-search
    .input-group
    .form-control,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-search
    .input-group
    .dataTables_wrapper
    select,
  .dataTables_wrapper
    .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-search
    .input-group
    select,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-search
    .input-group
    .input-group-text {
    background: transparent;
    border: 0;
    color: #000;
    padding: 0;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-search
    .input-group
    .form-control,
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-search
    .input-group
    .dataTables_wrapper
    select,
  .dataTables_wrapper
    .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-search
    .input-group
    select {
    margin-left: 0.5rem;
    height: 2.5rem;
  }
  .align-self-stretch,
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-settings,
  .navbar .navbar-menu-wrapper .navbar-nav.navbar-nav-right {
    align-self: stretch !important;
  }

  .align-items-stretch,
  .navbar .navbar-menu-wrapper .navbar-nav.navbar-nav-right {
    align-items: stretch !important;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .count-indicator {
    position: relative;
    padding: 0;
    text-align: center;
  }

  .navbar .navbar-menu-wrapper .navbar-nav .nav-item .nav-link {
    color: inherit;
    font-size: 0.875rem;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .count-indicator
    .count {
    position: absolute;
    left: 50%;
    width: 20px;
    height: 20px;
    border-radius: 100%;
    background: #ff4747;
    top: 0;
    color: #ffffff;
    font-size: 0.75rem;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown {
    position: absolute;
    font-size: 0.9rem;
    margin-top: 0;
    right: 0;
    left: auto;
    top: 60px;
  }
  .font-weight-normal {
    font-weight: 400 !important;
  }
  .mb-0,
  .my-0 {
    margin-bottom: 0 !important;
  }
  .float-left {
    float: left !important;
  }
  .dropdown-header {
    display: block;
    padding: 0.5rem 1.5rem;
    margin-bottom: 0;
    font-size: 0.875rem;
    color: #000;
    white-space: nowrap;
  }
  p {
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    line-height: 1.3rem;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item {
    margin-bottom: 0;
    padding: 0.65rem 1.5rem;
    cursor: pointer;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item
    .item-thumbnail
    img {
    width: 2.25rem;
    height: 2.25rem;
    border-radius: 50%;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item
    .item-content {
    padding-left: 0.937rem;
  }
  .flex-grow {
    flex-grow: 1;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item
    .ellipsis {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  h6,
  .h6 {
    font-size: 0.937rem;
  }
  .text-muted {
    color: #686868 !important;
  }
  .font-weight-light {
    font-weight: 300 !important;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile {
    margin-left: 1.8rem;
    margin-right: 1.8rem;
    white-space: nowrap;
  }
  .navbar .navbar-menu-wrapper .navbar-toggler {
    border: 0;
    color: inherit;
    font-size: 1.5rem;
    padding: 0;
    display: none;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-profile
    .nav-link
    .nav-profile-name {
    margin-left: 0.5rem;
    margin-right: 0.5rem;
    color: #4a4a4a;
    font-weight: 500;
    /* font-family: 'Montserrat', 'Open-Sans' */
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-profile
    .nav-link::after {
    color: #4a4a4a;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .dropdown-menu {
    border: none;
    box-shadow: 0px 3px 21px 0px rgba(0, 0, 0, 0.2);
  }
  .navbar-nav .dropdown-menu {
    position: static;
    float: none;
  }
  .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.nav-profile
    .nav-link::after {
    color: #4a4a4a;
  }
  .dropdown .dropdown-toggle:after {
    border-top: 0;
    border-right: 0;
    border-left: 0;
    border-bottom: 0;
    font: normal normal normal 24px/1 "Material Design Icons";
    content: "\F140";
    width: auto;
    height: auto;
    vertical-align: middle;
    line-height: 0.625rem;
    font-size: 1.25rem;
    margin-left: 0;
  }
  .count-indicator::after {
    display: none;
  }
  .dropdown-menu.show {
    display: block;
  }
  .dropdown-menu-right {
    right: 0;
    left: auto;
  }
  .dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    float: left;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #f3f3f3;
    border-radius: 0.25rem;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown i {
    margin-right: 0.5rem;
    vertical-align: middle;
  }
  .text-primary {
    color: #4d83ff !important;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .count-indicator i {
    font-size: 1.5rem;
    margin-right: 0;
    vertical-align: middle;
  }
  .ml-0,
  .mx-0 {
    margin-left: 0 !important;
  }
  .mr-0,
  .rtl
    .navbar
    .navbar-menu-wrapper
    .navbar-nav
    .nav-item.dropdown
    .navbar-dropdown
    .dropdown-item
    i,
  .mx-0 {
    margin-right: 0 !important;
  }
  .dropdown-toggle {
    white-space: nowrap;
  }
  .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile .nav-link img {
    width: 32px;
    height: 32px;
    border-radius: 100%;
  }
  @media (min-width: 992px) {
    .col-lg-12 {
      flex: 0 0 100%;
      max-width: 100%;
    }
    .d-lg-block {
      display: block !important;
    }
    .navbar .navbar-menu-wrapper .navbar-nav.navbar-nav-right {
      margin-left: auto;
    }
  }
  @media (max-width: 991px) {
    .navbar {
      flex-direction: row;
    }
    .navbar
      .navbar-brand-wrapper
      .navbar-brand-inner-wrapper
      .navbar-brand.brand-logo-mini {
      display: inline-block;
      width: 1.875rem;
    }
    .navbar-brand {
      display: none;
    }
    .navbar .navbar-brand-wrapper {
      width: 55px;
    }
    .navbar .navbar-menu-wrapper {
      width: calc(100% - 55px);
      padding-left: 15px;
      padding-right: 15px;
    }
    .navbar
      .navbar-brand-wrapper
      .navbar-brand-inner-wrapper
      .navbar-toggler:not(.navbar-toggler-right) {
      display: none;
    }
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown {
      position: static;
    }
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.dropdown .navbar-dropdown {
      left: 20px;
      right: 20px;
      top: 60px;
      width: calc(100% - 40px);
    }
    .navbar .navbar-menu-wrapper .navbar-toggler {
      display: block;
    }
  }
  @media (max-width: 768px) {
    .navbar .navbar-menu-wrapper .navbar-nav .nav-item.nav-profile {
      margin-left: 0.5rem;
      margin-right: 0.5rem;
    }
    .navbar
      .navbar-menu-wrapper
      .navbar-nav
      .nav-item.nav-profile
      .nav-link
      .nav-profile-name {
      display: none;
    }
  }
</style>

