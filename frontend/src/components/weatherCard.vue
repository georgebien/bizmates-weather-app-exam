<template>
  <div v-if="weatherData && forecast" class="weather-app-container">
    <div class="card weather-card mt-3">
      <div class="card-body">
        <h5 class="card-title weather-today-title">Weather today</h5>
        <div class="row align-items-center">
          <div class="col-md-6 today-main-section">
            <h3 class="city-name">{{ weatherData.city }}</h3>
            <div class="today-weather-icon-temp">
              <img
                :src="getWeatherIcon(weathers[weatherData.type])"
                width="180px"
                alt="Weather Icon"
                class="weather-icon-main"
              />
              <p class="current-temp">{{ weatherData.currentTemp }}°</p>
            </div>
            <h4 class="weather-type">{{ weatherData.type }}</h4>
          </div>

          <div class="col-md-6 today-details-section">
            <p class="detail-item">Feels like: <span class="detail-value">{{ weatherData.feelsLike }}°</span></p>
            <p class="detail-item">Humidity: <span class="detail-value">{{ weatherData.humidity }}%</span></p>
            <p class="detail-item">Min. temperature: <span class="detail-value">{{ weatherData.minTemp }}°</span></p>
            <p class="detail-item">Max. temperature: <span class="detail-value">{{ weatherData.maxTemp }}°</span></p>
            <p class="detail-item">Speed: <span class="detail-value">{{ weatherData.speed }} km/h</span></p>
            <p class="detail-item">Gustiness: <span class="detail-value">{{ weatherData.gust }} km/h</span></p>
          </div>
        </div>
      </div>
    </div>

    <div class="card card-forecast mt-3">
      <h3 class="forecast-title">7-Day Forecast</h3>
      <div class="days-container">
        <div
          class="day-forecast-item"
          v-for="data in forecast"
          :key="data.dt"
        >
          <p class="forecast-day-name">{{ data.day }}</p>
          <img
            :src="getWeatherIcon(weathers[data.weather[0].main])"
            width="65px"
            alt="Weather Icon"
            class="forecast-icon"
          />
          <p class="forecast-weather-type">{{ data.weather[0].main }}</p>
          <div class="forecast-temp-range">
            <span class="forecast-day-temp">Day: {{ parseInt(data.temp.day) }}°</span>
            <span class="forecast-night-temp">Night: {{ parseInt(data.temp.night) }}°</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { getForecast } from '../services/service';

export default {
  name: 'weatherCard',

  props: {
    weather: {
      type: Object,
      required: false
    }
  },

  data() {
    return {
      weatherData: null,
      weathers: {
        Snow: "snowy",
        Clouds: "cloudy",
        Rain: "rainy",
        Clear: "sunny",
        Thunderstorm: "thunder",
        Mist: "mist",
      },
      forecast: null,
      days: [
        'Sunday', 
        'Monday', 
        'Tuesday', 
        'Wednesday', 
        'Thursday', 
        'Friday', 
        'Saturday'
      ]
    }
  },

  mounted() {
    const currentDate = new Date();
    const nextWeek = new Date(
      currentDate.getTime() + 7 * 24 * 60 * 60 * 1000
    );
    let days = []

    while (currentDate <= nextWeek) {
      days.push(new Date(currentDate).getDay());
      currentDate.setDate(currentDate.getDate() + 1);
    }

    this.daysIndex = days.slice(1);
  },

  watch: {
    weather: function(value) {
      if (value) {
        this.formatData(value);
        this.getForecast();
      }
    },

    forecast: function(){
      for (let i = 0; i < this.daysIndex.length; i++) {
        this.forecast[i].day = this.days[this.daysIndex[i]]
      }
    }
  },

  methods: {
    formatData(data) {
      this.weatherData = {
        city: data.name,
        currentTemp: Math.round(data.main.temp),
        type: data.weather[0].main,
        feelsLike: Math.round(data.main.feels_like),
        humidity: Math.round(data.main.humidity),
        minTemp: Math.round(data.main.temp_min),
        maxTemp: Math.round(data.main.temp_max),
        speed: data.wind.speed,
        gust: data.wind.gust
      }
    },

    getWeatherIcon(element) {
      console.log(element)
      return new URL(
        `../assets/weather_elements/${element}.svg`, 
        import.meta.url
      ).href;
    },

    async getForecast() {
      const response = await getForecast(this.weatherData.city);

      if (!response) {
        alert('error');
      }

      this.forecast = response.data.list;
    }
  }
}
  
</script>


<style scoped>
body {
  background-color: #64B5F6;
  margin: 0;
  padding: 0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  min-height: 100vh;
}

.weather-app-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
  padding: 25px 20px;
  width: 100%;
  box-sizing: border-box;
}

.weather-card {
  background-color: #E3F2FD;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  color: #333;
  width: 100%;
  box-sizing: border-box;
  transition: all 0.2s ease;
  padding: 20px;
}

.weather-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
}

.weather-today-title {
  font-size: 1.2rem;
  font-weight: 500;
  color: #555;
  margin-bottom: 15px;
}

.city-name {
  font-size: 2.2rem;
  font-weight: 600;
  margin-bottom: 5px;
  color: #3F51B5;
  text-align: left;
  width: 100%;
}

.today-main-section {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding-left: 15px;
}

.today-weather-icon-temp {
  display: flex;
  align-items: center;
  margin-top: 10px;
  margin-bottom: 10px;
}

.weather-icon-main {
  width: 100px;
  height: auto;
  filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.1));
  margin-right: 15px;
}

.current-temp {
  font-size: 4.5rem;
  font-weight: 700;
  margin: 0;
  line-height: 1;
  color: #333;
}

.weather-type {
  font-size: 1.3rem;
  font-weight: 500;
  margin: 0;
  text-transform: capitalize;
  color: #607D8B;
  text-align: left;
  width: 100%;
}

.today-details-section {
  display: flex;
  flex-direction: column;
  justify-content: center;
  padding-right: 15px;
}

.detail-item {
  font-size: 1rem;
  margin-bottom: 8px;
  color: #555;
  display: flex;
  justify-content: space-between; 
  padding-bottom: 2px;
  border-bottom: 1px solid #eee;
}

.detail-item:last-child {
  border-bottom: none;
  margin-bottom: 0;
}

.detail-value {
  font-weight: 600;
  color: #333;
}

.card-forecast {
  background-color: #E3F2FD;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  color: #333;
  width: 100%;
  box-sizing: border-box;
  transition: all 0.2s ease;
  padding: 20px;
  overflow-x: auto;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}

.card-forecast:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
}

.card-forecast::-webkit-scrollbar {
  height: 8px;
}

.card-forecast::-webkit-scrollbar-track {
  background: #f0f0f0;
  border-radius: 10px;
}

.card-forecast::-webkit-scrollbar-thumb {
  background: #888;
  border-radius: 10px;
}

.card-forecast::-webkit-scrollbar-thumb:hover {
  background: #555;
}

.forecast-title {
  font-size: 1.2rem;
  font-weight: 500;
  color: #555;
  margin-bottom: 15px;
  padding-left: 15px;
  text-align: left;
}

.days-container {
  display: flex;
  gap: 15px;
  padding-bottom: 10px;
  padding-left: 45px;
  padding-right: 10px;
}

.day-forecast-item {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  flex-shrink: 0;
  width: 90px;
  text-align: center;
  padding: 10px 0;
}

.forecast-day-name {
  font-size: 0.95rem;
  font-weight: 600;
  margin-bottom: 8px;
  color: #424242;
}

.forecast-icon {
  width: 55px;
  height: auto;
  margin-bottom: 8px;
  filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.08));
}

.forecast-weather-type {
  font-size: 0.85rem;
  font-weight: 500;
  margin-bottom: 5px;
  text-transform: capitalize;
  color: #607D8B;
}

.forecast-temp-range {
  display: flex;
  flex-direction: column;
  align-items: center;
  font-size: 0.8rem;
  color: #546E7A;
}

.forecast-day-temp {
  font-weight: 600;
  color: #424242;
}

.forecast-night-temp {
  opacity: 0.8;
}

@media (max-width: 768px) {
  .weather-card {
    padding: 15px;
  }
  .weather-today-title {
    margin-bottom: 10px;
  }
  .city-name {
    font-size: 2rem;
  }
  .today-weather-icon-temp {
    margin-top: 5px;
    margin-bottom: 5px;
  }
  .weather-icon-main {
    width: 90px;
  }
  .current-temp {
    font-size: 4rem;
  }
  .weather-type {
    font-size: 1.2rem;
  }
  .detail-item {
    font-size: 0.95rem;
  }
  .card-forecast {
    padding: 15px;
  }
  .forecast-title {
    margin-bottom: 10px;
  }
  .day-forecast-item {
    width: 80px;
  }
  .forecast-icon {
    width: 50px;
  }
}

@media (max-width: 480px) {
  .weather-app-container {
    padding: 15px;
    gap: 15px;
  }
  .search-bar {
    height: 40px;
  }
  .weather-card {
    padding: 10px;
  }
  .city-name {
    font-size: 1.8rem;
  }
  .today-weather-icon-temp {
    flex-direction: column;
    align-items: center;
  }
  .weather-icon-main {
    width: 80px;
    margin-right: 0;
    margin-bottom: 5px;
  }
  .current-temp {
    font-size: 3.5rem;
  }
  .weather-type {
    font-size: 1.1rem;
    text-align: center;
  }
  .today-main-section {
    align-items: center;
    padding-left: 0;
  }
  .today-details-section {
    padding-right: 0;
  }
  .card-forecast {
    padding: 10px;
  }
  .day-forecast-item {
    width: 70px;
  }
  .forecast-icon {
    width: 45px;
  }
  .forecast-day-name, .forecast-weather-type, .forecast-temp-range {
    font-size: 0.75rem;
  }
}
</style>
 