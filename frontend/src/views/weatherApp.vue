<template>
  <div>
    <main>
      <Multiselect
        v-model="selectedCity"
        :options="cities"
        placeholder="Select a city"
        :searchable="true"
        :can-clear="false"
      />
      
      <div class="alert alert-primary mt-3" role="alert" v-show="selectedCity && !weather">
        <div class="d-flex align-items-center">
          <div class="spinner-border" role="status" aria-hidden="true"></div>
          <strong style="margin-left: 10px;">Loading...</strong>
        </div>
      </div>

      <weatherCard 
        v-show="selectedCity && weather" 
        :weather="weather"
      ></weatherCard>

      <placesCard 
        v-show="selectedCity && weather" 
        :city="selectedCity"
        :weather="weather"
      ></placesCard>
    </main>
  </div>
</template>

<script>
import Multiselect from '@vueform/multiselect'
import '@vueform/multiselect/themes/default.css'
import weatherCard from '../components/weatherCard.vue'
import placesCard from '../components/placesCard.vue'
import { getWeather } from '../services/service';

export default {
  name: 'WeatherApp',
  
  components: {
    Multiselect,
    weatherCard,
    placesCard
  },

  data() {
    return {
      cities: [
        'Tokyo', 
        'Yokohama', 
        'Kyoto', 
        'Osaka', 
        'Sapporo', 
        'Nagoya'
      ],
      selectedCity: null,
      weather: null
    }
  },

  watch: {
    selectedCity: function(value) {
      if (!value) {
        this.cities = [];
      }

      this.getWeather(value)
    }
  },

  mounted() {
    this.cities = this.cities.sort()
  },

  methods: {
    async getWeather(city) {
      this.weather = null;

      const response = await getWeather(city);

      if (!response) {
        alert('error');
      }

      this.weather = response.data;
    }
  }
}
</script>

<style>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}
body {
  font-family: 'montserrat', sans-serif;
}

main {
  min-height: 100vh;
  padding: 25px;
  margin: auto;
  width: 50%;
}

.vs__dropdown-toggle {
  height: 70px !important;
}
</style>