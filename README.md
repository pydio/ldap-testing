# pydio/ldap-testing

This repository provides an easy way to generate various simple _dummy_ docker images that we commonly use to test Pydio Cells against an LDAP external directory.

## How To Use

## How To Build a Custom Image

### Pre-requisite

### Build

To build, simply run following commands:

```sh
# To generate the default minimal image with only ~10 users
make build
# To generate a larger image
export TAG=medium && make build
```

### Publish

***Pydio Mainteners only***:

You should have a docker account configured on your machine.
Once you have modified and tested the image you want to update, only run:

```sh
make tiny # generate and publish an image with ~20 users
make medium # generate and publish an image with ~12k users
```

## Built upon

We used the [Mockaroo](https://mockaroo.com/) to generate our set of test data.

The image we use is based on the nice [osixia/openldap:latest](https://github.com/osixia/docker-openldap) docker image that provides a running OpenLDAP in a docker container out of the box.
