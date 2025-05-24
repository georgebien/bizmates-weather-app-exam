<template>
	<div v-if="places && weather" class="card-places-container">
		<div class="card card-places mt-3">
			<div class="card-body">
				<h5 class="card-title places-title">Places to visit in {{ city }}</h5>
				<div class="row">
					<div class="col-md-6 col-lg-4 mt-3" v-for="place in places" :key="place.fsq_id">
						<div class="card place-item-card">
							<div class="card-body">
								<h5 class="card-title place-name">{{ place.name }}</h5>
								<p class="card-text place-location">Location: {{ place.location.formatted_address }}</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import { getPlaces } from '../services/service';

export default {
	name: 'PlacesCard',

	props: {
		city : {
			type: String,
			required: false
		},
		weather: {
      type: Object,
      required: false
    }
	},

	data() {
		return {
			places: null
		}
	},

	watch: {
		city: function(value) {
			if (value) {
				this.getPlaces(value);
			}
		}
	},

	methods: {
		async getPlaces(city) {
     	const response = await getPlaces(city);

			if (!response) {
				alert('error');
			}

			this.places = response.data.results;

		}
	}
}
</script>

<style scoped>
.card-places-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 0px 20px;
  width: 100%;
  box-sizing: border-box;
}

.card-places {
  background-color: #E3F2FD;
  border-radius: 12px;
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
  color: #333;
  width: 100%;
  box-sizing: border-box;
  transition: all 0.2s ease;
  padding: 20px;
}

.card-places:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 18px rgba(0, 0, 0, 0.15);
}

.places-title {
  font-size: 1.2rem;
  font-weight: 500;
  color: #555;
  margin-bottom: 15px;
}

.place-item-card {
  background-color: #F8F9FA;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
  transition: all 0.2s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.place-item-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
}

.place-name {
  font-size: 1.05rem;
  font-weight: 600;
  color: #3F51B5;
  margin-bottom: 8px;
}

.place-location {
  font-size: 0.9rem;
  color: #607D8B;
  line-height: 1.4;
  margin-bottom: 0;
}

@media (max-width: 768px) {
  .card-places {
    padding: 15px;
  }
  .places-title {
    margin-bottom: 10px;
  }
  .place-name {
    font-size: 1rem;
  }
  .place-location {
    font-size: 0.85rem;
  }
  .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
  }
  .col-lg-4 {
    flex: 0 0 100%;
    max-width: 100%;
  }
}

@media (max-width: 480px) {
  .card-places {
    padding: 10px;
  }
  .places-title {
    font-size: 1.1rem;
    margin-bottom: 10px;
    padding-left: 0;
    text-align: center;
  }
  .place-item-card {
    padding: 10px;
  }
  .place-name {
    font-size: 0.9rem;
  }
  .place-location {
    font-size: 0.75rem;
  }
}
</style>