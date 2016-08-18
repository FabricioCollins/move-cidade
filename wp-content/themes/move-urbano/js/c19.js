$( document ).ready(function() {
	var c19=new C19();

	c19.populateSelect($("#cod_estados"), c19contentJSON);

	$("#cod_estados").change(function() {
		var item=$(this);
		if( item.val() ) {
			var uf=c19.findUfById(item.val());
			c19.populateSelect(
				$("#cod_cidades"), 
				uf.cities
			);			
			$('.cidades').addClass('ativo');
		}
		else {			
			$('#cod_cidades').html('<option value="">-- Escolha um estado --</option>');
			$('.cidades').removeClass('ativo');
			$(".card-wrapper").empty();
		}
	});

	$("#cod_cidades").change(function() {
		var item=$(this);
		var resultContainer=$(".card-wrapper");
		resultContainer.empty();
		var uf=c19.findUfById($("#cod_estados").val());
		var city=c19.findByName(uf.cities, item.val());
		if(city)
			c19.renderResult(city.contents,resultContainer);
	});
});

var C19=function() {
	var self=this;
	
	this.findUfById=function(id) {
		for(var index in c19contentJSON) {
			if(c19contentJSON[index].id==id)
				return c19contentJSON[index];
		}
		return null;
	};

	this.findById=function(list, id) {
		for(var index in list) {
			if(list[index].id==id)
				return list[index];
		}
	};

	this.findByName=function(list, name) {
		for(var index in list) {
			if(list[index].name==name)
				return list[index];
		}
	};

	this.renderResult=function(contents, element) {
		$.each(contents, function (i, item) {
			var card=self.buildResultItem(item);
			element.append(card);
		});
	};

	this.buildResultItem=function(item) {
		var result="";
			result+="<li class='col span_4_of_12'>";
			result+="	<div class='card'>";
			result+="		<h3>"+item.nome+"</h3>";
			result+="		<div class='botao-wrapper'>";
			if(item.site) {result+="			<a class='botao' href='"+item.site+"' target='_blank'>Site</a>";}
			if(item.fc) {result+="			<a class='botao' href='"+item.fc+"' target='_blank'>Contato</a>";}
			result+="		</div>";
			result+="	</div>";
			result+="</li>";

			return result;
	};

	this.populateSelect=function(select, list) {
		select.empty();
		list.sort(self.sortByName);
		select.append(new Option("Selecione", ""));
		$.each(list, function (i, item) {
			var option = new Option(item.name, item.id);
			select.append(option);
		});
	};

	this.sortByName=function(a, b) {
		var aName = a.name.toLowerCase();
		var bName = b.name.toLowerCase(); 
		return ((aName < bName) ? -1 : ((aName > bName) ? 1 : 0));
	};

	this.sortSelect=function(select) {
		select.append(select.find("option").remove().sort(function(a, b) {
		    var at = $(a).text(), bt = $(b).text();
		    return (at > bt)?1:((at < bt)?-1:0);
		}));
	};
};

var c19contentJSON=[
   {
      "id":"SP",
      "name":"São Paulo",
      "cities":[
         {
            "id":"São Paulo",
            "name":"São Paulo",
            "contents":[
               {
                  "nome":"Secretaria dos Transportes Metropolitanos",
                  "site":"http://www.stm.sp.gov.br/",
                  "fc":"http://www.saopaulo.sp.gov.br/sis/fale.php"
               },
               {
                  "nome":"Secretaria Municipal de Transportes",
                  "site":"http://www.prefeitura.sp.gov.br/cidade/secretarias/transportes/",
                  "fc":"http://sac.prefeitura.sp.gov.br/"
               },
               {
                  "nome":"Metrô",
                  "site":"http://www.metro.sp.gov.br",
                  "fc":"http://www.metro.sp.gov.br/fale-conosco"
               },
               {
                  "nome":"CPTM",
                  "site":"http://www.cptm.sp.gov.br",
                  "fc":"http://www.cptm.sp.gov.br/Pages/atendimento.aspx"
               },
               {
                  "nome":"SPTrans",
                  "site":"http://www.sptrans.com.br",
                  "fc":"http://www.sptrans.com.br/sac"
               },
               {
                  "nome":"EMTU",
                  "site":"http://www.emtu.sp.gov.br/",
                  "fc":"http://www.emtu.sp.gov.br/emtu/fale-conosco/entre-em-contato/por-formulario-eletronico.fss"
               },
               {
                  "nome":"CET",
                  "site":"http://www.cetsp.com.br",
                  "fc":"http://cetsp1.cetsp.com.br/falecomsac"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.prefeitura.sp.gov.br",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.sp.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.sp.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"RJ",
      "name":"Rio de Janeiro",
      "cities":[
         {
            "id":"Rio de Janeiro",
            "name":"Rio de Janeiro",
            "contents":[
               {
                  "nome":"Secretaria de Estado de Transportes",
                  "site":"http://www.rj.gov.br/web/setrans",
                  "fc":"http://www.rj.gov.br/web/falecomagente"
               },
               {
                  "nome":"Secretaria Municipal de Transportes",
                  "site":"http://www.rio.rj.gov.br/web/smtr/",
                  "fc":"http://www.1746.rio.gov.br"
               },
               {
                  "nome":"MetrôRio",
                  "site":"http://www.metrorio.com.br",
                  "fc":"http://www.metrorio.com.br/fale-conosco/atendimento-ao-usuario"
               },
               {
                  "nome":"SuperVia",
                  "site":"www.supervia.com.br",
                  "fc":"http://www.supervia.com.br/canal-do-cliente-sac-supervia/"
               },
               {
                  "nome":"BRT",
                  "site":"http://www.brtrio.com",
                  "fc":"http://www.brtrio.com/contato"
               },
               {
                  "nome":"Detro",
                  "site":"http://www.detro.rj.gov.br/",
                  "fc":"http://www.detro.rj.gov.br/contato.php"
               },
               {
                  "nome":"CET Rio",
                  "site":"http://www.rio.rj.gov.br/web/smtr/cet-rio",
                  "fc":"www.1746.rio.gov.br"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://riotransparente.rio.rj.gov.br",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.rj.gov.br",
                  "fc":""
               },
               {
                  "nome":"Barcas",
                  "site":"http://www.grupoccr.com.br/barcas/",
                  "fc":"http://www.grupoccr.com.br/barcas/fale-conosco"
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.rj.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www.rio.rj.gov.br/web/proconcarioca",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"MG",
      "name":"Minas Gerais",
      "cities":[
         {
            "id":"Belo Horizonte",
            "name":"Belo Horizonte",
            "contents":[
               {
                  "nome":"Secretaria de Estado de Transportes e Obras Públicas",
                  "site":"http://www.transportes.mg.gov.br/",
                  "fc":"http://www.transportes.mg.gov.br/fale-conosco"
               },
               {
                  "nome":"Portal da Prefeitura",
                  "site":"http://portalpbh.pbh.gov.br/pbh/",
                  "fc":"http://portal6.pbh.gov.br/sacweb/work/Ctrl/CtrlSolicitacao?acao=8"
               },
               {
                  "nome":"CBTU",
                  "site":"http://www.cbtu.gov.br/index.php/pt/belo-horizonte/",
                  "fc":"http://www.cbtu.gov.br/index.php/pt/fale-com-o-metro"
               },
               {
                  "nome":"BHTrans",
                  "site":"http://www.bhtrans.pbh.gov.br",
                  "fc":"http://servicosbhtrans.pbh.gov.br/bhtrans/e-servicos/S20F01-faleconosco.asp"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.pbh.gov.br/transparenciabh/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.brasil.gov.br/barra#acesso-informacao",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"https://www.mpmg.mp.br/areas-de-atuacao/defesa-do-cidadao/consumidor/apresentacao/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://portaldeservicos.pbh.gov.br/portalservicos/view/paginas/linhaVidaTemas.jsf",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"ES",
      "name":"Espírito Santo",
      "cities":[
         {
            "id":"Vitória",
            "name":"Vitória",
            "contents":[
               {
                  "nome":"Secretaria de Estado dos Transportes e Obras Públicas",
                  "site":"http://setop.es.gov.br/",
                  "fc":"http://setop.es.gov.br/fale-conosco"
               },
               {
                  "nome":"Secretaria de Transportes, Trânsito e Infraestrutura Urbana",
                  "site":"http://www.vitoria.es.gov.br/setran",
                  "fc":"http://www.vitoria.es.gov.br/prefeitura/fale-conosco"
               },
               {
                  "nome":"Ceturb",
                  "site":"http://www.ceturb.es.gov.br/",
                  "fc":"http://www.ceturb.es.gov.br/default.asp"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.vitoria.es.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.acessoainformacao.es.gov.br/SelecionarOrgao.aspx",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.es.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www.vitoria.es.gov.br/erro.php#a_procon_atendimentoonline",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"RS",
      "name":"Rio Grande do Sul",
      "cities":[
         {
            "id":"Porto Alegre",
            "name":"Porto Alegre",
            "contents":[
               {
                  "nome":"Secretaria dos Transportes",
                  "site":"http://www.seinfra.rs.gov.br/",
                  "fc":"http://www.centraldeinformacao.rs.gov.br/login"
               },
               {
                  "nome":"Secretaria Municipal dos Transportes",
                  "site":"http://www2.portoalegre.rs.gov.br/governo_municipal/default.php?p_secao=28",
                  "fc":"http://156poa.procempa.com.br/sistemas/externo/"
               },
               {
                  "nome":"Trensurb",
                  "site":"http://www.trensurb.gov.br",
                  "fc":"http://www.trensurb.gov.br/paginas/paginas_detalhe.php?codigo_sitemap=9"
               },
               {
                  "nome":"EPTC",
                  "site":"http://www.eptc.com.br",
                  "fc":"http://www.eptc.com.br/eptc_118/reclamacoes.asp"
               },
               {
                  "nome":"Metroplan",
                  "site":"http://www.metroplan.rs.gov.br/",
                  "fc":"http://www.centraldeinformacao.rs.gov.br/login"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"www2.portoalegre.rs.gov.br/transparencia",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.rs.gov.br/webpart/system/PaginaInicial.aspx",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.rs.gov.br/portal/index.php",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www2.portoalegre.rs.gov.br/procon/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"PR",
      "name":"Paraná",
      "cities":[
         {
            "id":"Curitiba",
            "name":"Curitiba",
            "contents":[
               {
                  "nome":"Secretaria de Estado do Desenvolvimento Urbano",
                  "site":"http://www.desenvolvimentourbano.pr.gov.br/",
                  "fc":"http://www.cge.pr.gov.br/modules/conteudo/conteudo.php?conteudo=53"
               },
               {
                  "nome":"Secretaria Municipal de Trânsito",
                  "site":"http://www.setran.curitiba.pr.gov.br/",
                  "fc":"http://www.central156.org.br/"
               },
               {
                  "nome":"URBS",
                  "site":"http://www.urbs.curitiba.pr.gov.br/",
                  "fc":"http://www.central156.org.br/"
               },
               {
                  "nome":"Comec",
                  "site":"http://www.comec.pr.gov.br/",
                  "fc":"http://www.comec.pr.gov.br/modules/conteudo/conteudo.php?conteudo=226"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.curitiba.pr.gov.br/leiacessoinformacao",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.portaldatransparencia.pr.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.pr.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"SC",
      "name":"Santa Catarina",
      "cities":[
         {
            "id":"Florianópolis",
            "name":"Florianópolis",
            "contents":[
               {
                  "nome":"Secretaria de Estado da Infraestrutura",
                  "site":"http://www.sie.sc.gov.br/",
                  "fc":"http://www.ouvidoria.sc.gov.br/"
               },
               {
                  "nome":"Secretaria Municipal de Mobilidade Urbana",
                  "site":"http://www.pmf.sc.gov.br/entidades/transportes/",
                  "fc":"http://www.pmf.sc.gov.br/ouvidoria/index.php?pagina=requisicao"
               },
               {
                  "nome":"Deter",
                  "site":"http://www2.deter.sc.gov.br/",
                  "fc":"http://www.comec.pr.gov.br/modules/conteudo/conteudo.php?conteudo=226"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://ouvidoria.pmf.sc.gov.br/cidadao_lai.php?id_gestor=174",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.ouvidoria.sc.gov.br/cidadao/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.sc.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www.pmf.sc.gov.br/entidades/procon/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"DF",
      "name":"Distrito Federal",
      "cities":[
         {
            "id":"Brasília",
            "name":"Brasília",
            "contents":[
               {
                  "nome":"Secretaria de Estado de Mobilidade do Distrito Federal",
                  "site":"http://www.semob.df.gov.br/",
                  "fc":"http://www.semob.df.gov.br/ouvidoria.html"
               },
               {
                  "nome":"Metrô DF",
                  "site":"http://www.metro.df.gov.br",
                  "fc":"http://www.metro.df.gov.br/ouvidoria"
               },
               {
                  "nome":"DFTRANS",
                  "site":"http://www.dftrans.df.gov.br",
                  "fc":"http://www.dftrans.df.gov.br/servicos/atendimento-ao-cidadao.html"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.transparencia.df.gov.br",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.df.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"GO",
      "name":"Goiás",
      "cities":[
         {
            "id":"Goiânia",
            "name":"Goiânia",
            "contents":[
               {
                  "nome":"Secretaria de Estado de Gestão e Planejamento",
                  "site":"http://www.segplan.go.gov.br/",
                  "fc":"http://www.cge.go.gov.br/ouvidoria/"
               },
               {
                  "nome":"Secretaria Municipal de Trânsito, Transportes e Mobilidade",
                  "site":"http://www4.goiania.go.gov.br/portal/site.asp?s=822&m=1536",
                  "fc":"http://www4.goiania.go.gov.br/portal/site.asp?s=822&m=3341"
               },
               {
                  "nome":"RMTC",
                  "site":"http://www.rmtcgoiania.com.br/",
                  "fc":"http://www.rmtcgoiania.com.br/sac"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.cge.go.gov.br/ouvidoria/frm_manifestacao.php?tipo_manifestacao=7",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www4.goiania.go.gov.br/portal/site.asp?s=1836&xxx=1",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.go.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www.goiania.go.gov.br/html/procon/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"MT",
      "name":"Mato Grosso",
      "cities":[
         {
            "id":"Cuiabá",
            "name":"Cuiabá",
            "contents":[
               {
                  "nome":"Secretaria de Estado de Infraestrutura e Logística",
                  "site":"http://www.setpu.mt.gov.br/#",
                  "fc":"http://www.ouvidoria.mt.gov.br/falecidadao/"
               },
               {
                  "nome":"Secretaria de Mobilidade Urbana",
                  "site":"http://www.cuiaba.mt.gov.br/secretarias/mobilidade-urbana/",
                  "fc":"http://www.cuiaba.mt.gov.br/fale-conosco/"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.transparencia.mt.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"https://sic.tce.mt.gov.br/47",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.mt.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www.cuiaba.mt.gov.br/orgaos/procon-municipal/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"MS",
      "name":"Mato Grosso do Sul",
      "cities":[
         {
            "id":"Campo Grande",
            "name":"Campo Grande",
            "contents":[
               {
                  "nome":"Secretaria de Estado de Infraestrutura",
                  "site":"http://www.seinfra.ms.gov.br/",
                  "fc":"http://www.portal.ms.gov.br/fale-cidadao?post_id=157&site_id=109"
               },
               {
                  "nome":"Secretaria Municipal de Infraestrutura, Transporte e Habitação",
                  "site":"http://www.pmcg.ms.gov.br/SEINTRHA",
                  "fc":"http://www.pmcg.ms.gov.br/seintrha/faleConosco"
               },
               {
                  "nome":"Agência Municipal de Transporte e Trânsito",
                  "site":"http://agetran.ms.gov.br/agetran/",
                  "fc":"http://agetran.ms.gov.br/agetran/fale-conosco-0"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.pmcg.ms.gov.br/transparencia",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.ms.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.ms.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"MA",
      "name":"Maranhão",
      "cities":[
         {
            "id":"São Luís",
            "name":"São Luís",
            "contents":[
               {
                  "nome":"Agência de Estadual de Transporte e Mobilidade Urbana",
                  "site":"http://www.mob.ma.gov.br/",
                  "fc":"http://www.mob.ma.gov.br/contatos/"
               },
               {
                  "nome":"Secretaria Municipal de Trânsito e Transportes",
                  "site":"http://www.saoluis.ma.gov.br/smtt",
                  "fc":"http://www.saoluis.ma.gov.br/subportal_subpagina.asp?site=215"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.lei131.com.br/apex/portal/f?p=661:1",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.ma.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.ma.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"PI",
      "name":"Piauí",
      "cities":[
         {
            "id":"Teresina",
            "name":"Teresina",
            "contents":[
               {
                  "nome":"Secretaria de Estado dos Transportes",
                  "site":"http://www.setrans.pi.gov.br/index.php",
                  "fc":"http://www.setrans.pi.gov.br/contato.php"
               },
               {
                  "nome":"Superintendência Municipal de Transportes e Trânsito",
                  "site":"http://strans.teresina.pi.gov.br/",
                  "fc":"http://strans.teresina.pi.gov.br/fale-conosco/"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.teresina.pi.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.pi.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.mppi.mp.br/internet/index.php?option=com_content&view=category&layout=blog&id=145&Itemid=124",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"CE",
      "name":"Ceará",
      "cities":[
         {
            "id":"Fortaleza",
            "name":"Fortaleza",
            "contents":[
               {
                  "nome":"Agência Reguladora de Serviços Públicos Delegados",
                  "site":"http://www.arce.ce.gov.br/index.php/pagina-inicial",
                  "fc":"http://www.arce.ce.gov.br/index.php/ouvidoria"
               },
               {
                  "nome":"Autarquia Municipal de Trânsito e Cidadania",
                  "site":"http://www.fortaleza.ce.gov.br/amc",
                  "fc":"http://www.fortaleza.ce.gov.br/amc/fale-conosco-0"
               },
               {
                  "nome":"Metrofor",
                  "site":"http://www.metrofor.ce.gov.br/",
                  "fc":"http://www.ouvidoria.ce.gov.br/"
               },
               {
                  "nome":"Etufor",
                  "site":"http://www.fortaleza.ce.gov.br/etufor",
                  "fc":"http://www.fortaleza.ce.gov.br/etufor/fale-conosco"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.fortaleza.ce.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://transparencia.ce.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.decon.ce.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"RN",
      "name":"Rio Grande do Norte",
      "cities":[
         {
            "id":"Natal",
            "name":"Natal",
            "contents":[
               {
                  "nome":"Secretaria da Infraestrutura",
                  "site":"http://www.sin.rn.gov.br/",
                  "fc":"http://www.sin.rn.gov.br/Conteudo.asp?TRAN=PORTIF&TARG=81&ACT=&PAGE=0&PARM=&LBL="
               },
               {
                  "nome":"Secretaria Municipal de Mobilidade Urbana",
                  "site":"https://natal.rn.gov.br/sttu/",
                  "fc":"https://natal.rn.gov.br/sttu2/paginas/ctd-1091.html"
               },
               {
                  "nome":"CBTU",
                  "site":"http://www.cbtu.gov.br/index.php/pt/natal",
                  "fc":"http://www.cbtu.gov.br/index.php/pt/fale-com-o-metro"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"https://natal.rn.gov.br/transparencia",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.rn.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://natal.rn.gov.br/procon/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"PB",
      "name":"Paraíba",
      "cities":[
         {
            "id":"João Pessoa",
            "name":"João Pessoa",
            "contents":[
               {
                  "nome":"Secretaria de Estado dos Recursos Hídricos, do Meio Ambiente e da Ciência e Tecnologia",
                  "site":"http://paraiba.pb.gov.br/meio-ambiente-dos-recursos-hidricos-e-da-ciencia-e-tecnologia/",
                  "fc":"http://ouvidoria.pb.gov.br/"
               },
               {
                  "nome":"Superintendência de Mobilidade Urbana",
                  "site":"http://www.joaopessoa.pb.gov.br/secretarias/semob/",
                  "fc":""
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.joaopessoa.pb.gov.br/sic/open.php",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://transparencia.pb.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://procon.pb.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www.joaopessoa.pb.gov.br/secretarias/procon/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"PE",
      "name":"Pernambuco",
      "cities":[
         {
            "id":"Recife",
            "name":"Recife",
            "contents":[
               {
                  "nome":"Secretaria de Transportes",
                  "site":"http://www.setra.pe.gov.br/web/setra",
                  "fc":"http://www.detran.al.gov.br/detran-al/contato"
               },
               {
                  "nome":"Companhia de Trânsito e Transporte Urbano do Recife",
                  "site":"http://www2.recife.pe.gov.br/pagina/companhia-de-transito-e-transporte-urbano-do-recife-cttu",
                  "fc":""
               },
               {
                  "nome":"CBTU",
                  "site":"http://www.cbtu.gov.br/index.php/pt/recife/",
                  "fc":"www.cbtu.gov.br/index.php/pt/fale-com-o-metro"
               },
               {
                  "nome":"Grande Recife Consórcio de Transporte",
                  "site":"http://www.granderecife.pe.gov.br/web/grande-recife",
                  "fc":"http://www.granderecife.pe.gov.br/web/grande-recife/fale-conosco"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.recife.pe.gov.br/codigos/web/geral/home.php",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.lai.pe.gov.br/web/portal",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.pe.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www.recife.pe.gov.br/pr/secjuridicos/procon/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"AL",
      "name":"Alagoas",
      "cities":[
         {
            "id":"Maceió",
            "name":"Maceió",
            "contents":[
               {
                  "nome":"Detran",
                  "site":"http://www.detran.al.gov.br/",
                  "fc":"http://www.detran.al.gov.br/detran-al/contato"
               },
               {
                  "nome":"Superintendência Municipal de Transporte e Trânsito",
                  "site":"http://www.maceio.al.gov.br/smtt/",
                  "fc":"http://www.maceio.al.gov.br/smtt/fale-conosco/"
               },
               {
                  "nome":"CBTU",
                  "site":"http://www.cbtu.gov.br/index.php/pt/sistemas-cbtu/maceio",
                  "fc":"http://www.cbtu.gov.br/index.php/pt/fale-com-o-metro"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.transparencia.maceio.al.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.cgu.gov.br/acessoainformacaogov/index.asp",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.al.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"SE",
      "name":"Sergipe",
      "cities":[
         {
            "id":"Aracaju",
            "name":"Aracaju",
            "contents":[
               {
                  "nome":"Secretaria de Estado da Infraestrutura e do Desenvolvimento Urbano",
                  "site":"http://www.seinfra.se.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Superintendência Municipal de Transportes e Trânsito",
                  "site":"http://www.smttaju.com.br/index.php",
                  "fc":"http://tag.aracaju.se.gov.br:5050/tag/"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://financas.aracaju.se.gov.br/transparencia/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparenciasergipe.se.gov.br/setp/index.html",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.se.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://procon.aracaju.se.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"BA",
      "name":"Bahia",
      "cities":[
         {
            "id":"Salvador",
            "name":"Salvador",
            "contents":[
               {
                  "nome":"Secretaria de Desenvolvimento Urbano",
                  "site":"http://www.sedur.ba.gov.br/",
                  "fc":"http://www.tag2.ouvidoriageral.ba.gov.br/tag/NovaManif.html"
               },
               {
                  "nome":"Secretaria de Mobilidade",
                  "site":"http://www.mobilidade.salvador.ba.gov.br/",
                  "fc":"http://www.mobilidade.salvador.ba.gov.br/index.php/contatos"
               },
               {
                  "nome":"CCR Metrô Bahia",
                  "site":"http://www.ccrmetrobahia.com.br/",
                  "fc":"http://www.ccrmetrobahia.com.br/fale-conosco"
               },
               {
                  "nome":"Companhia de Transportes do Estado da Bahia",
                  "site":"http://www.ctb.ba.gov.br/",
                  "fc":"http://www.tag2.ouvidoriageral.ba.gov.br/tag/NovaManif160615.dll/EXEC"
               },
               {
                  "nome":"Transalvador",
                  "site":"http://www.transalvador.salvador.ba.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.salvador.ba.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.ba.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Ferry Boat",
                  "site":"http://internacionaltravessias.com.br/",
                  "fc":"http://internacionalmaritima.com.br/?page_id=1452"
               }
            ]
         }
      ]
   },
   {
      "id":"RR",
      "name":"Roraima",
      "cities":[
         {
            "id":"Boa Vista",
            "name":"Boa Vista",
            "contents":[
               {
                  "nome":"Detran",
                  "site":"https://www.rr.getran.com.br/site/",
                  "fc":""
               },
               {
                  "nome":"Secretaria Municipal de Segurança Urbana e Trânsito",
                  "site":"http://www.boavista.rr.gov.br/prefeitura-secretarias-e-orgaos-municipais-estrutura/smst-secretaria-municipal-de-seguranca-urbana-e-transito",
                  "fc":""
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.boavista.rr.gov.br/portal/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.rr.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Municipal",
                  "site":"http://www.boavista.rr.gov.br/prefeitura-secretarias-e-orgaos-municipais-estrutura/procon",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"AP",
      "name":"Amapá",
      "cities":[
         {
            "id":"Macapá",
            "name":"Macapá",
            "contents":[
               {
                  "nome":"Detran",
                  "site":"http://www.detran.ap.gov.br/index.html",
                  "fc":"https://detranamapa.com.br/site/fale-conosco.jsp"
               },
               {
                  "nome":"Companhia de Transportes e Trânsito",
                  "site":"http://macapa.ap.gov.br/noticias/secretarias/80-ctmac",
                  "fc":""
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia2.macapa.ap.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.ap.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"AM",
      "name":"Amazonas",
      "cities":[
         {
            "id":"Manaus",
            "name":"Manaus",
            "contents":[
               {
                  "nome":"Detran",
                  "site":"http://www.detran.am.gov.br/",
                  "fc":"http://www.detran.am.gov.br/fale-conosco/"
               },
               {
                  "nome":"Superintendência Municipal de Transportes Urbanos",
                  "site":"http://smtu.manaus.am.gov.br/",
                  "fc":"http://smtu.manaus.am.gov.br/fale-conosco/"
               },
               {
                  "nome":"Manaustrans",
                  "site":"http://transito.manaus.am.gov.br/",
                  "fc":"http://transito.manaus.am.gov.br/fale-conosco/"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.manaus.am.gov.br/transparencia/v2/#/home",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.am.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"PA",
      "name":"Pará",
      "cities":[
         {
            "id":"Belém",
            "name":"Belém",
            "contents":[
               {
                  "nome":"Secretaria de Estado de Transportes",
                  "site":"http://setran.pa.gov.br/novosite/",
                  "fc":"http://setran.pa.gov.br/novosite/contato"
               },
               {
                  "nome":"Superintendência Executiva de Mobilidade Urbana",
                  "site":"http://semob.belem.pa.gov.br/site/",
                  "fc":"http://www.belem.pa.gov.br/semob/site/?page_id=56"
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://www.belem.pa.gov.br/transparencia",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.pa.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.pa.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"AC",
      "name":"Acre",
      "cities":[
         {
            "id":"Rio Branco",
            "name":"Rio Branco",
            "contents":[
               {
                  "nome":"Detran",
                  "site":"http://www.detran.ac.gov.br/",
                  "fc":"http://www.detran.ac.gov.br/,index.php?option=com_ckforms&view=ckforms&id=3&Itemid=97"
               },
               {
                  "nome":"Superintendência de Transportes e Trânsito de Rio Branco",
                  "site":"http://www.riobranco.ac.gov.br/index.php/secretarias/rbtrans-transportes-e-transito.html",
                  "fc":""
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.riobranco.ac.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://sefaznet.ac.gov.br/transparencia/servlet/portaltransparencia",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.procon.ac.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"RO",
      "name":"Rondônia",
      "cities":[
         {
            "id":"Porto Velho",
            "name":"Porto Velho",
            "contents":[
               {
                  "nome":"Detran",
                  "site":"http://www.detran.ro.gov.br/",
                  "fc":"http://www.detran.ro.gov.br/central-de-relacionamento/"
               },
               {
                  "nome":"Secretaria Municipal de Transportes e Trânsito",
                  "site":"http://www.portovelho.ro.gov.br/artigo/,semtran-secretaria-municipal-de-transportes-e-tr%C3%A2nsito",
                  "fc":""
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://transparencia.portovelho.ro.gov.br/Site/Principal/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://www.transparencia.ro.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://www.rondonia.ro.gov.br/seas/institucional/atendimento-social/procon-protecao-e-defesa-do-consumidor/",
                  "fc":""
               }
            ]
         }
      ]
   },
   {
      "id":"TO",
      "name":"Tocantins",
      "cities":[
         {
            "id":"Palmas",
            "name":"Palmas",
            "contents":[
               {
                  "nome":"Secretaria de Infraestrutura, Habitação e Serviços Públicos",
                  "site":"http://seinf.to.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Secretaria Municipal de Acessibilidade, Mobilidade, Trânsito e Transporte",
                  "site":"http://www.palmas.to.gov.br/secretaria/secretarias/",
                  "fc":""
               },
               {
                  "nome":"Transparência Municipal",
                  "site":"http://portaldatransparencia.palmas.to.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Transparência Estadual",
                  "site":"http://transparencia.to.gov.br/",
                  "fc":""
               },
               {
                  "nome":"Procon Estadual",
                  "site":"http://procon.to.gov.br/",
                  "fc":""
               }
            ]
         }
      ]
   }

];