/*c0050b792f6ca30c10a3dac4a0213f59217eb673*/(function(){var a=window.Ext;function b(){return window.App.server||{}}a.override(a.direct.RemotingProvider,{getCallData:function(c){return{action:c.getAction(),method:c.getMethod(),data:c.getData(),type:"rpc",tid:c.getId(),server:b()}}});window.ExtDirectManagerProvider=a.direct.Manager.addProvider({id:"ServerProvider",url:"http://www.gaiaehr.org/demo/data/appRouter.php",type:"remoting",namespace:"DataProvider",actions:{authProcedures:[{name:"login",len:1}],PoolArea:[{name:"getPatientsByPoolAreaAccess",len:1}]}});a.Direct.on("exception",function(c){a.Viewport.unmask();say("Type: Exception, Message: "+c.config.message+", Where: "+c.config.where)})})();