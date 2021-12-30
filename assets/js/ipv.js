function vidoeModal(data) {

	//player variable 
	let playertag = null;
	let playerData = data;

	//prepare the video link for  Local Video and Id for YouTuve, Vimeo 
	if (isValidURL(playerData.url)) {

		//declare variable for Vidoe ID and Link
		let link = null;
		let linkID = null;

		//create Url Object 
		link = new URL(playerData.url);

		//Create Youtube video ID nad player tag
		if ((link.hostname == 'youtu.be') || (link.hostname == 'www.youtube.com')) {
			link.hostname == 'youtu.be' ? linkID = link.pathname.replace('/', '') : linkID = link.searchParams.get('v');

			//create div tag for youtube
			playertag = createNode('div', {
				id: 'player',//this id will be dynamic
			});
			//set cutom attrbutes
			let arryAttr = {
				'data-plyr-provider': 'youtube',
				'data-plyr-embed-id': linkID,//this id will be dynamic
			}
			setCustomAttributes(playertag, arryAttr)
		}
		//Create Vimeo Video ID and Player tag
		else if (link.hostname == 'vimeo.com') {
			linkID = link.pathname.replace('/', '')
			//create div tag for youtube
			playertag = createNode('div', {
				id: 'player',//this id will be dynamic
			});
			//set cutom attrbutes
			let arryAttr = {
				'data-plyr-provider': 'vimeo',
				'data-plyr-embed-id': linkID,//this id will be dynamic
			}
			setCustomAttributes(playertag, arryAttr)
		}
		//Create local Video link and Player tag
		else {


			link = link.href;

			//create video tag
			playertag = createNode('video', {
				id: 'player',//this id will be dynamic
				playsinline: true,
				controls: true,
			});
			//set cutom attrbutes
			let arryAttr = {
				'data-poster': "/path/to/poster.jpg",//this image will be dynamic
			}
			setCustomAttributes(playertag, arryAttr);

			//create source tag
			sourcetag = createNode('source', {
				src: link,//this src will be dynamic
				type: 'video/mp4',//this type will be dynamic
			});
			playertag.appendChild(sourcetag);
		}


		//create div tag for Modal Box
		var videoModalBox = createNode('div', {
			class: 'video-modal-box',
		});
		const videoModalContainer = createNode('div', {
			class: 'video-modal-container',
		});
		var closeButton = createNode('button', {
			class: 'modal-button is-close',
		});

		videoModalContainer.appendChild(playertag);
		videoModalContainer.appendChild(closeButton);
		videoModalBox.appendChild(videoModalContainer);
		document.body.appendChild(videoModalBox);

	} else {

		return;
	}


	//Helper funtion for creating tag with attributes
	function createNode(node, attributes) {
		const el = document.createElement(node);
		for (let key in attributes) {
			el.setAttribute(key, attributes[key]);
		}
		return el;
	}

	//Helper function for setting multiple custop attrubutes
	function setCustomAttributes(tag, arryAttr) {
		for (let key in arryAttr) {
			tag.setAttribute(key, arryAttr[key]);
		}
		return tag;
	}
	//Helper function for testing valid url
	function isValidURL(string) {
		var res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
		return (res !== null)
	};

	//Modal box function
	function showModalBox() {

		if (!videoModalBox.classList.contains("show")) {
			videoModalBox.classList.add('show');
			//autoplay
			if (playerData.auto_play !== null) {
				player.play();
			}

			//mute 
			if (playerData.mute !== null) {
				player.muted = true;
			}
		} else {
			videoModalBox.classList.remove('show');
			player.pause();
			player.currentTime = 0;
		}

	}

	//Make PlYr.io Object
	const player = new Plyr('#player');

	//hide controsl
	if (playerData.controls == null) {
		player.config.controls = [];
	}

	//Onload Event listener
	window.addEventListener('load', showModalBox);

	//close Eventlistener
	closeButton.addEventListener('click', showModalBox);
}

// call the function
if (ipvData.url.length) {
	vidoeModal(ipvData);
}

