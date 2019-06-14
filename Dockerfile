FROM osixia/openldap:latest
LABEL authors="Pydio Team <contact@pydio.com>"

ADD bootstrap /container/service/slapd/assets/config/bootstrap
ADD assets/certs /container/service/slapd/assets/certs
ADD environment /container/environment/01-custom