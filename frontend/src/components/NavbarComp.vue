<template>
  <div>
    <nav class="navbar fixed-top navbar-expand-lg">
      <div class="container">
        <router-link
          to="/"
          class="navbar-brand"
          exact-active-class="bg-transparent"
          >Artikel</router-link
        >
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <router-link to="/" class="nav-link" aria-current="page"
                >Home</router-link
              >
            </li>
            <li class="nav-item">
              <router-link to="/master" class="nav-link" aria-current="page"
                >Master</router-link
              >
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </div>
</template>

<script>
export default {
  name: "NavbarComp",
};
</script>

<style>
.navbar {
  background-color: #093b6e !important;
}
.navbar-brand,
.nav-link {
  color: white !important;
}
.navbar-nav {
  padding: 0;
}
.nav-item {
  margin-left: 10px;
  text-align: center;
}
.btn-logout {
  margin: 0;
  border-radius: 20px !important;
  background-color: red !important;
  color: white !important;
}
.navbar-toggler {
  background-color: #f5f5f5 !important;
}

@media (max-width: 992px) {
  .navbar-nav {
    padding: 10px 0;
  }
  .nav-item {
    margin-left: 0;
  }
  .btn-logout {
    margin: 10px 0;
  }
}
</style>
