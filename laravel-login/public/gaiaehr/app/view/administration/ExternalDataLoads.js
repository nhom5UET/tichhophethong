/*
 GaiaEHR (Electronic Health Records)
 ExternalDataLoads.js
 Documents
 Copyright (C) 2012 Ernesto Rodriguez

 This program is free software: you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation, either version 3 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
Ext.define('App.view.administration.ExternalDataLoads',
{
	extend : 'App.ux.RenderPanel',
	id : 'panelExternalDataLoads',
	pageTitle : i18n('external_data_loads'),
	/**
	 * define the layout 'accordion'
	 * and few more configs
	 */
	pageLayout :
	{
		type : 'accordion',
		animate : true,
		activeOnTop : true
	},
	initComponent : function()
	{
		var me = this;
		/**
		 * var stores is used to hold all the stores inside this class
		 * this way, if I want to reload all the stores at once, I can do it
		 * using a for loop
		 *
		 * see function loadStores()
		 *
		 * @type {Array}
		 */
		me.stores = [];

		me.stores.push(me.icd9Store = Ext.create('App.store.administration.ExternalDataLoads',
		{
			codeType : 'ICD9'
		}));
		me.stores.push(me.icd10Store = Ext.create('App.store.administration.ExternalDataLoads',
		{
			codeType : 'ICD10',
			groupField : 'version'
		}));
		me.stores.push(me.rxnormStore = Ext.create('App.store.administration.ExternalDataLoads',
		{
			codeType : 'RXNORM'
		}));
		me.stores.push(me.snomedStore = Ext.create('App.store.administration.ExternalDataLoads',
		{
			codeType : 'SNOMED'
		}));

		/**
		 * Since all the grid are very similar I created a function that return a grid
		 */
		me.icd9Grid = me.getCodeGrid('Available ICD9 Data', me.icd9Store, false);
		me.icd10Grid = me.getCodeGrid('Available ICD10 Data', me.icd10Store, true);
		me.rxnormGrid = me.getCodeGrid('Available RxNorm Data', me.rxnormStore, false);
		me.snomedGrid = me.getCodeGrid('Available SNOMED Data', me.snomedStore, false);

		/**
		 * Same thing with the forms
		 */
		me.icd9Form = me.getCodeForm('ICD9');
		me.icd10Form = me.getCodeForm('ICD10');
		me.rxnormForm = me.getCodeForm('RXNORM');
		me.snomedForm = me.getCodeForm('SNOMED');

		/**
		 * Here are the panels used inside the accordion layout
		 */
		me.icd9 = Ext.create('Ext.form.Panel',
		{
			title : i18n('update_icd9'),
			layout : 'border',
			items : [me.icd9Grid, me.icd9Form]
		});

		me.icd10 = Ext.create('Ext.panel.Panel',
		{
			title : i18n('update_icd10'),
			layout : 'border',
			items : [me.icd10Grid, me.icd10Form]
		});

		me.rxnorm = Ext.create('Ext.panel.Panel',
		{
			title : i18n('update_rxnorm'),
			layout : 'border',
			items : [me.rxnormGrid, me.rxnormForm]
		});

		me.snomed = Ext.create('Ext.panel.Panel',
		{
			title : i18n('update_snomed'),
			layout : 'border',
			items : [me.snomedGrid, me.snomedForm]
		});

		me.pageBody = [me.icd9, me.icd10, me.rxnorm, me.snomed];
		me.callParent(arguments);
	},

	getCodeForm : function(action)
	{
		var me = this;
		return Ext.create('Ext.form.Panel',
		{
			bodyPadding : 10,
			region : 'center',
			action : action,
			frame : true,
			bodyStyle : 'background-color:white',
			bodyBorder : true,
			margin : '5 0 5 0',
			items : [
			{
				xtype : 'fieldset',
				styleHtmlContent : true,
				action : action,
				title : i18n('current_version_installed'),
				html : i18n('no_data_installed'),
				tpl : i18n('revivion_name') + ':  {revision_name}<br>' + i18n('revision_number') + ':  {revision_number}<br>' + i18n('revision_version') + ': {revision_version}<br>' + i18n('revision_date') + ':    {revision_date}<br>' + i18n('imported_on') + ':      {imported_date}'
			},
			{
				xtype : 'fieldset',
				title : i18n('installation'),
				action : 'installation',
				styleHtmlContent : true,
				html : me.getInstallationDetails(action)
			},
			{
				xtype : 'fieldset',
				title : i18n('upload'),
				action : 'upload',
				items : [
				{

					xtype : 'filefield',
					name : 'filePath',
					buttonText : i18n['Select file'] + '...',
					emptyText : i18n('data_file'),
					width : 350,
					labelWidth : 50,
					allowBlank : false
				}]
			}],
			api :
			{
				submit : ExternalDataUpdate.updateCodesWithUploadFile
			},
			buttons : [
			{
				text : i18n('update'),
				action : action,
				scope : me,
				handler : me.uploadFile
			}]
		});
	},

	getCodeGrid : function(title, store, grouping)
	{
		var me = this;
		return Ext.create('Ext.grid.Panel',
		{
			title : title,
			store : store,
			region : 'west',
			width : 500,
			margin : '5 0 5 0',
			padding : 0,
			split : true,
			columns : me.getDefaultColumns(),
			listeners :
			{
				scope : me,
				itemdblclick : me.onCodeDblClick
			},
			features : grouping ? [
			{
				ftype : 'grouping'
			}] : []
		});

	},

	getDefaultColumns : function()
	{
		return [
		{
			header : i18n('date'),
			dataIndex : 'date',
			width : 98
		},
		{
			header : i18n('version'),
			dataIndex : 'version',
			width : 98
		},
		{
			header : i18n('file'),
			dataIndex : 'basename',
			width : 300
		}];
	},

	getInstallationDetails : function(action)
	{
		if (action == 'ICD9')
		{
			return '<p>Steps to install the ICD 9 database:</p>' + '<ol>' + '<li>The raw data feed release can be obtained from <a href="https://www.cms.gov/Medicare/Coding/ICD9ProviderDiagnosticCodes/codes.html">this location</a></li>' + '<li>Upload the downloaded .zip file, or place the downloaded ICD 9 database zip file into the following directory: contrib/icd9</li>' + '<li>Double Click the zip file from the "Available ICD9 Data" grid to install</li>' + '</ol>' + '<p style="color:red">NOTE: Importing external data can take more than an hour depending on your hardware configuration. For example, one of the RxNorm data tables contain in excess of 6 million rows.</p>'
		}
		else
		if (action == 'ICD10')
		{
			return '<p>Steps to install the ICD 10 database:</p>' + '<ol>' + '<li>The raw data feed release can be obtained from <a href="https://www.cms.gov/Medicare/Coding/ICD10">this location</a></li>' + '<li>Upload the downloaded .zip file, or place the downloaded ICD 10 database zip files into the following directory: contrib/icd10</li>' + '<li>Double Click the zip file from the "Available ICD10 Data" grid to install</li>' + '</ol>' + '<p>These are the ICD10 2012 links:</p>' + '<ol>' + '<li><a href="https://www.cms.gov/Medicare/Coding/ICD10/Downloads/DiagnosisGEMs_2012.zip">DiagnosisGEMs_2012</a></li>' + '<li><a href="https://www.cms.gov/Medicare/Coding/ICD10/Downloads/ProcedureGEMs_2012.zip">ProcedureGEMs_2012</a></li>' + '<li><a href="https://www.cms.gov/Medicare/Coding/ICD10/Downloads/ReimbursementMapping_2012.zip">ReimbursementMapping_2012</a></li>' + '<li><a href="https://www.cms.gov/Medicare/Coding/ICD10/Downloads/2012_PCS_long_and_abbreviated_titles.zip">2012_PCS_long_and_abbreviated_titles</a></li>' + '<li><a href="https://www.cms.gov/Medicare/Coding/ICD10/Downloads/ICD10OrderFiles_2012.zip">ICD10OrderFiles_2012</a></li>' + '</ol>' + '<p style="color:red">NOTE: Importing external data can take more than an hour depending on your hardware configuration. For example, one of the RxNorm data tables contain in excess of 6 million rows.</p>'
		}
		else
		if (action == 'RXNORM')
		{
			return '<p>Steps to install the RxNorm database:</p>' + '<ol>' + '<li>The first step is to open an account with the Unified Medical Language System web site <a href="https://utslogin.nlm.nih.gov/cas/login">here</a></li>' + '<li>Then the raw data feed release can be obtained from <a href="http://www.nlm.nih.gov/research/umls/rxnorm/docs/rxnormfiles.html">this location</a></li>' + '<li>Upload the downloaded .zip file, or place the downloaded RxNorm database zip file into the following directory: contrib/rxnorm.</li>' + '<li>Double Click the zip file from the "Available RxNorm Data" grid to install</li>' + '</ol>' + '<p style="color:red">NOTE: Only the full monthly RxNorm release is currently supported</p>'
		}
		else
		if (action == 'SNOMED')
		{
			return 'Lorem ipsum dolor sit amet, porta nam suscipit sed id, ' + 'vestibulum velit tortor velit viverra, non enim justo, ' + 'purus nec, libero sociis lobortis, eu et leo mauris velit. ' + 'Magnis tellus blandit fringilla, morbi mauris commodo, nec morbi ac non'
		}

	},

	uploadFile : function(btn)
	{
		var me = this, form = btn.up('form').getForm();

		if (form.isValid())
		{
			form.submit(
			{
				waitMsg : i18n('uploading_and_updating_code_database') + '...',
				scope : me,
				params :
				{
					codeType : btn.action
				},
				success : function(fp, o)
				{
					say(o.result);
				},
				failure : function(fp, o)
				{
					say(o.result);
				}
			});
		}
	},

	onCodeDblClick : function(grid, record)
	{
		var me = this;
		app.setTask(false);
		grid.el.mask(i18n('installing_database_please_wait') + '...');
		ExternalDataUpdate.updateCodes(record.data, function(provider, response)
		{
			grid.el.unmask();
			if (response.result.success)
			{
				me.setCurrentCodesInfo();
				me.alert(i18n('new_database_installed'), 'info');
			}
			else
			{
				me.alert(response.result.error, 'error');
			}
			app.setTask(true);
		});
	},

	setCurrentCodesInfo : function()
	{
		var me = this, codes, fieldset;
		ExternalDataUpdate.getCurrentCodesInfo(function(provider, response)
		{
			codes = response.result;
			for (var i = 0; i < codes.length; i++)
			{
				if (codes[i].data !== false)
				{
					fieldset = me.query('fieldset[action="'+codes[i].data.codeType+'"]')[0];
					fieldset.update(codes[i].data);
				}
			}
		});
	},

	loadStores : function()
	{
		var me = this;
		for (var i = 0; i < me.stores.length; i++)
		{
			me.stores[i].load(
			{
				params :
				{
					pid : me.pid
				}
			});
		}
	},

	/**
	 * This function is called from Viewport.js when
	 * this panel is selected in the navigation panel.
	 * place inside this function all the functions you want
	 * to call every this panel becomes active
	 */
	onActive : function(callback)
	{
		this.loadStores();
		this.setCurrentCodesInfo();
		callback(true);
	}
});
//ens servicesPage class