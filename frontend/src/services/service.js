import axios from "axios";

export async function getWeather(city) {
	try {
		const response = await axios.get('/api/get-weather', {
			params: {
				city: city,
			}
		});

		return response.data;
	} catch (error) {
		return false;
	}
}

export async function getForecast(city) {
		try {
			const response = await axios.get('/api/get-forecast', {
				params: {
					city: city,
				}
			})

			return response.data;
		} catch (error) {
			return false;
		}
}

export async function getPlaces(city) {
	try {
		const response = await axios.get('/api/get-places', {
			params: {
				city: city,
			}
		})

		return response.data;
	} catch (error) {
		return false;
	}
}