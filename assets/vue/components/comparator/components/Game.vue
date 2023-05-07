<template>
    <div class="game-card">

        <a :href="launch" class="image-container" :class="{ hover: hoverImage }" @mouseenter="hoverImage = true" @mouseleave="hoverImage = false">
          <img :src="game.header_image" alt="Game logo" class="game-logo">
          <div class="overlay" v-if="hoverImage">
            <p class="text-uppercase">Play on Steam</p>
          </div>
        </a>

        <a :href="gameUrl" target="_blank" class="game-title h3">{{ game.name }}</a>
        <p class="game-description">{{ game.short_description }}</p>

        <div class="game-details">
            <p class="game-plateforms">
                <span :class="{enabled : game.platforms.windows}" title="Windows"><i class="fa-brands fa-windows fa-lg"></i></span>
                <span :class="{enabled : game.platforms.mac}" title="Mac"><i class="fa-brands fa-apple fa-lg"></i></span>
                <span :class="{enabled : game.platforms.linux}" title="Linux"><i class="fa-brands fa-linux fa-lg"></i></span>
            </p>
        </div>

    </div>
</template>

<script>
export default {
    name: 'Game',
    props: {
        appId: {
            type: String,
            required: true,
        },
        game: {
            type: Object,
            required: true,
        },
    },
    data() {
        return {
            hoverImage: false,
        }
    },
    computed: {
        launch() {
            return `steam://run/${this.appId}`
        },
        gameUrl() {
            return `https://store.steampowered.com/app/${this.appId}`
        }
    },
    filters: {
        formatDate(date) {
            return new Date(date).toLocaleDateString('fr-FR', { year: 'numeric', month: 'long', day: 'numeric' })
        }
    }
}
</script>

<style lang="scss" scoped>
@import "../../../../styles/utils/variables";


.game-card {
  display: flex;
  flex-direction: column;
  width: 300px;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 0px 10px rgba(0, 0, 0, 0.5);
  color: $white;
}

.image-container {
  z-index: 2;
  position: relative;
  display: inline-block;
  cursor: pointer;
  overflow: hidden;
}
.game-logo {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  cursor: pointer;
}

.game-title {
  font-size: 20px;
  margin-top: 10px;
  margin-bottom: 5px;
}

.game-description {
  flex: 1;
  font-size: 14px;
  line-height: 1.5;
  margin-bottom: 10px;
}

.game-details {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  font-size: 14px;
}

.game-plateforms {
  display: flex;
  color: #94949467;

  i {
    margin-left: .5rem;
  }

  & .enabled i {
    color: #ffffff;
  }
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.8);
  display: flex;
  justify-content: center;
  align-items: center;
  color: white;
  font-size: 24px;
  text-align: center;
  opacity: 0;
  border-top-right-radius: 10px;
  border-top-left-radius: 10px;
  transition: opacity 0.3s ease-in-out;
}

.overlay p {
  margin: 0;
}

.image-container.hover .overlay {
  opacity: 1;
}
</style>