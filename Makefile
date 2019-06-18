# Default variables
OWNER=pydio
IMG_NAME=ldap-testing
NAME=$(OWNER)/$(IMG_NAME)
CURR_DIR=$(shell pwd)
# we build a tiny image by default
TAG ?= tiny


# simply insures targets are never cached: "a phony target is simply a target that is always out-of-date"...
.PHONY: debug clean pre-build build build-nocache publish set-tiny-tag tiny

debug:
	@echo 'Tag: $(TAG)'

clean:
	@rm -rf ./bootstrap/ldif 

pre-build: clean
	@rm -f ./assets/$(TAG)/ldif/63-users.ldif
	@php ./scripts/generate-users-ldif.php $(CURR_DIR)/assets/$(TAG)/dummy-users.csv >> ./assets/$(TAG)/ldif/63-users.ldif
	@cp -R ./assets/$(TAG)/ldif ./bootstrap/ldif 

build: pre-build
	docker build -t $(NAME):$(TAG) --rm .

build-nocache: pre-build
	docker build -t $(NAME):$(TAG) --no-cache --rm .

publish: build ## push to Docker 
	@docker login
	docker push $(NAME):$(TAG)
	@echo 'published $(NAME):$(TAG)'

tiny: TAG=tiny
tiny: publish

medium: TAG=medium
medium: publish
