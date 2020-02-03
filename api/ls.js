//Here we persist our token into our local storage for verification at the server side

const saveToken = token => {

	window.localStorage.setItem("login", token);
} 

const getToken = () => {

	return window.locaStorage.getItem("login");

}