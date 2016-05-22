function Provider(providerPhp) 
{
	var provider = providerPhp['Provider'];
	
	this.id = provider.id;
	this.name = provider.name;
	this.position = new google.maps.LatLng(provider.latlng.latitude, provider.latlng.longitude);
	this.adresse = provider.adresse;
	this.description = provider.description;
	this.tel = provider.tel ? provider.tel.replace(/(.{2})(?!$)/g,"$1 ") : '';
	
	
	this.products = [];
	for (var i = 0; i < provider.products.length; i++) 
	{
		var product = [];

		product.name = provider.products[i].product.name;
		product.nameShort = provider.products[i].product.name_short;
		product.nameFormate = provider.products[i].product.name_formate;
		product.descriptif = provider.products[i].descriptif;

		this.products.push(product);
	};

	this.mainProduct = provider.main_product;
	this.horaires = provider.horaires;
	this.type = provider.type;	
	
	this.isInitialized_ = false;

	this.isVisible_ = false;

	this.biopenMarker_ = null;
	this.htmlRepresentation_ = '';
	this.formatedHoraire_ = null;

	// TODO delete providerPhp['Provider'] ?
}

Provider.prototype.initialize = function () 
{		
	this.biopenMarker_ = new BiopenMarker(this.id, this.position);
	/*this.htmlRepresentation_ = '<span>'+this.name_ +'</span>';*/
	this.isInitialized_ = true;
};

Provider.prototype.show = function () 
{		
	this.biopenMarker_.show();
	this.isVisible_ = true;
};

Provider.prototype.hide = function () 
{		
	this.biopenMarker_.hide();
	this.isVisible_ = false;
	// unbound events (click etc...)?
};

Provider.prototype.containsProduct = function (productName) 
{		
	for (var i = 0; i < this.products.length; i++) 
	{
		if (this.products[i].nameFormate == productName)
		{
			return true;
		} 
	}
	return false;
};

Provider.prototype.getHtmlRepresentation = function () 
{		
	if (this.htmlRepresentation_ == '')
	{
		var html = Twig.render(providerTemplate, {provider : this, horaires : this.getFormatedHoraires()});
		this.htmlRepresentation_ = html;
		return html;
		
	}
	else return this.htmlRepresentation_;
};

Provider.prototype.getFormatedHoraires = function () 
{		
	if (this.formatedHoraire_ == null )
	{		
		this.formatedHoraire_ = {};
		var new_key;
		for(key in this.horaires)
		{
			new_key = key.split('_')[1];
			this.formatedHoraire_[new_key] = this.formateJourHoraire(this.horaires[key]);
		}
	}
	return this.formatedHoraire_;
};

Provider.prototype.formateJourHoraire = function (jourHoraire) 
{		
	if (jourHoraire == null)
	{		
		return 'fermé';
	}
	var result = '';
	if (jourHoraire.plage1debut != null)
	{
		result+= this.formateDate(jourHoraire.plage1debut);
		result+= ' - ';
		result+= this.formateDate(jourHoraire.plage1fin);
	}
	if (jourHoraire.plage2debut != null)
	{
		result+= ' et ';
		result+= this.formateDate(jourHoraire.plage2debut);
		result+= ' - ';
		result+= this.formateDate(jourHoraire.plage2fin);
	}
	return result;
};

Provider.prototype.formateDate = function (date) 
{		
	return date.split('T')[1].split(':00+0100')[0];
};






// --------------------------------------------
//            SETTERS GETTERS
// ---------------------------------------------

Provider.prototype.getId = function () 
{		
	return this.id;
};

Provider.prototype.getPosition = function () 
{		
	return this.position;
};

Provider.prototype.getName = function () 
{		
	return this.name;
};

Provider.prototype.getMainProduct = function () 
{		
	return this.mainProduct;
};

Provider.prototype.getProducts = function () 
{		
	return this.products;
};

Provider.prototype.getMarker= function () 
{		
	return this.biopenMarker_.getRichMarker();
};

Provider.prototype.isVisible = function () 
{		
	return this.isVisible_;
};

Provider.prototype.isInitialized = function () 
{		
	return this.isInitialized_;
};


